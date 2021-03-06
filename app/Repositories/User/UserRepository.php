<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Enums\RequestType;
use App\Models\UserRequest;
use App\Enums\RequestStatus;
use Illuminate\Http\Response;
use App\Events\UserRequestEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRepository implements UserInterface
{
    protected $user_request, $user;

    public function __construct(UserRequest $user_request, User $user)
    {
        $this->user_request = $user_request;
        $this->user = $user;
    }

    public function create($request)
    {
        $data = $this->user_request->create([
            'admin_id' => \request()->user()->id,
            'request_type' => RequestType::CREATE,
            'payload' => json_encode($request)
        ]);

        event(new UserRequestEvent());

        return $data;
    }

    public function update($request)
    {
        $data = $this->user_request->create([
            'admin_id' => \request()->user()->id,
            'request_type' => RequestType::UPDATE,
            'payload' => json_encode($request),
            'user_id' => $request['user_id']
        ]);

        event(new UserRequestEvent());

        return $data;
    }

    public function delete($id)
    {
        $data = $this->user_request->create([
            'admin_id' => \request()->user()->id,
            'request_type' => RequestType::DELETE,
            'user_id' => $id
        ]);

        event(new UserRequestEvent());

        return $data;
    }

    public function fetch()
    {
        return $this->user_request->whereNot('admin_id', \request()->user()->id)->where('status', RequestStatus::PENDING)->get();
    }

    public function takeAction(int $request_id, string $action)
    {
        $request = $this->user_request->where('id', $request_id)->first();

        if (!$request) {
            throw new HttpResponseException(response()->json([
                'message'   => 'Request not found.',
                'data'      => null
            ], Response::HTTP_NOT_FOUND));
        }

        if ($request->status != RequestStatus::PENDING) {
            throw new HttpResponseException(response()->json([
                'message'   => 'This is not a pending request',
                'data'      => null
            ], Response::HTTP_BAD_REQUEST));
        }

        if ($request->admin_id != \request()->user()->id) {

            if ($action == RequestStatus::APPROVE) {

                ($request->request_type == RequestType::CREATE) ? $this->createUser($request->payload) : (($request->request_type == RequestType::UPDATE) ? $this->updateUser($request->payload) : $this->deleteUser($request->user_id));

                return $request->update([
                    'status' => RequestStatus::APPROVE,
                    'approved_by' => \request()->user()->id
                ]);

            } else {
                return $request->delete();
            }

        } else {
            throw new HttpResponseException(response()->json([
                'message'   => 'Whoops!!! You cannot take action on your request.',
                'data'      => null
            ], Response::HTTP_NOT_FOUND));
        }

    }

    private function createUser($data)
    {
        $data = json_decode($data);

        $user = $this->user->create([
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'email' => $data->email,
            'password' => Hash::make('password')
        ]);

        $user->assignRole('user');

    }

    private function updateUser($data)
    {
        $data = json_decode($data);

        $user = $this->user->where('id', $data->user_id)->first();

        if (isset($data->firstname))
            $payload['firstname'] = $data->firstname;

        if (isset($data->lastname))
            $payload['lastname'] = $data->lastname;

        if (isset($data->email))
            $payload['email'] = $data->email;


        $user->update($payload);
    }

    private function deleteUser($user_id)
    {
        $user = $this->user->where('id', $user_id)->first();
        if($user) {
            $user->delete();
        }
    }

}

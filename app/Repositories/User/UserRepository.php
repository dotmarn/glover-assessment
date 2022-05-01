<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Enums\RequestType;
use App\Models\UserRequest;
use App\Enums\RequestStatus;
use App\Notifications\RequestEmailNotification;

class UserRepository implements UserInterface
{
    protected $user_request;

    public function __construct(UserRequest $user_request) {
        $this->user_request = $user_request;
    }

    public function create($request)
    {
        $data = $this->user_request->create([
            'admin_id' => \request()->user()->id,
            'request_type' => RequestType::CREATE,
            'payload' => json_encode($request)
        ]);

        $admins = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->whereNot('id', \request()->user()->id)->get();

        if ($admins) {
            foreach($admins as $admin) {
                $admin->notify(new RequestEmailNotification());
            }
        }

        return $data;

    }

    public function update($request)
    {

    }

    public function delete($request)
    {

    }

    public function fetch()
    {
        return $this->user_request->whereNot('admin_id', \request()->user()->id)->where('status', RequestStatus::PENDING)->get();
    }
}

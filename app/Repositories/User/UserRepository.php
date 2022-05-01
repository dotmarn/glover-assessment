<?php

namespace App\Repositories\User;

use App\Enums\RequestType;
use App\Models\UserRequest;

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

        return $data;
    }

    public function update($request)
    {

    }

    public function delete($request)
    {

    }
}

<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;

class UsersController extends Controller
{
    protected $users_repo;

    public function __construct(UserInterface $user_contract)
    {
        $this->users_repo = $user_contract;
    }

    public function create(CreateUserRequest $request)
    {

    }

}

<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Repositories\User\UserInterface;

class UsersController extends Controller
{
    protected $users_repo;

    public function __construct(UserInterface $user_contract)
    {
        $this->users_repo = $user_contract;
    }

    public function create(CreateUserRequest $request)
    {
        $validated = $request->safe()->only(['firstname', 'lastname', 'email']);
        $user = $this->users_repo->create($validated);

        if ($user) {
           return response()->json([
            'message' => 'Request saved successfully',
            'data' => $user
           ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Whoops!!! Unable to create record at this time',
            'data' => null
        ], Response::HTTP_BAD_REQUEST);
    }

}

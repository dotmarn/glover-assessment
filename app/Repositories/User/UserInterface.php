<?php

namespace App\Repositories\User;

interface UserInterface
{
    public function create(array $request);

    public function update($request);

    public function delete($request);

}

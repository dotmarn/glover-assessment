<?php

namespace App\Repositories\User;

interface UserInterface
{
    public function create(array $request);

    public function update($request);

    public function delete($request);

    public function fetch();

    public function takeAction(int $id, string $type);

}

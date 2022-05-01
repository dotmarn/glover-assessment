<?php

namespace App\Repositories\User;

interface UserInterface
{
    public function create(array $request);

    public function update(array $request);

    public function delete($request);

    public function fetch();

    public function takeAction(int $id, string $type);

}

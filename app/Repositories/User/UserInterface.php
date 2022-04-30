<?php

namespace App\Repositories;

interface UserInterface
{
    public function create($request);

    public function update($request);

    public function delete($request);

}

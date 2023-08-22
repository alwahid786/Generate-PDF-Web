<?php

namespace App\Repositories;
use App\Repositories\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function getUser()
    {
        dd('hi');
    }
}

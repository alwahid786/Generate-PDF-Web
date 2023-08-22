<?php

namespace App\Repositories;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Models\User;

class AdminRepository implements AdminRepositoryInterface
{
    public function getUser()
    {
        $query = User::where('user_status', 'pending')->get();
        return $query;
    }
}

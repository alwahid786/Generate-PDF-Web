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

    // update user status
    public function updateStatus($id)
    {

        $query = User::where('id', $id)->update([
            "user_status" => 'approved',
        ]);

        return $query;

    }
}

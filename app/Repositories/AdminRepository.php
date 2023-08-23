<?php

namespace App\Repositories;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Models\User;

class AdminRepository implements AdminRepositoryInterface
{
    public function getUser()
    {

        $query = User::where('is_admin', NULL)->get();

        return $query;

    }

    // update user status
    public function updateStatus($id, $status)
    {

        $query = User::where('id', $id)->update([
            "user_status" => $status,
        ]);

        return $query;

    }
}

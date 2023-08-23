<?php

namespace App\Repositories\Interfaces;

interface AdminRepositoryInterface
{

    // get user
    public function getUser();

    // update status
    public function updateStatus($id, $status);

}

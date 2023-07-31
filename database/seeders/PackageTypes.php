<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PackageType;

class PackageTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => "Type 1"],
            ['title' => "Type 2"],
            ['title' => "Type 3"],
            ['title' => "Type 4"],
            ['title' => "Type 5"],
        ];
        PackageType::insert($data);
    }
}

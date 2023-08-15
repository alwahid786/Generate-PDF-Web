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
            ['title' => "Specification Package"],
            ['title' => "Lighting Legend"],
            ['title' => "Submittal Package"],
            ['title' => "Record Drawings"],
        ];
        PackageType::insert($data);
    }
}

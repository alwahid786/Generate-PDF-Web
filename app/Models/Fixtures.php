<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixtures extends Model
{
    use HasFactory;

    public function legends()
    {
        return $this->hasMany(LighteningLegendInfo::class, 'fixture_id');
    }
}

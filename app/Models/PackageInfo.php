<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageInfo extends Model
{
    use HasFactory;

    public function fixtures()
    {
        return $this->hasMany(Fixtures::class, 'package_info_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

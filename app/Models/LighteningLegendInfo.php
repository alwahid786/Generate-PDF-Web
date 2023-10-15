<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LighteningLegendInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'legend_id',
        'manufacturer',
        'description',
        'part_number',
        'lamp',
        'voltage',
        'dimming'
    ];
}

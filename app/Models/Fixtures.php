<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixtures extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'part_number',
        'pdf_path',
        'package_info_id',
        'image_path',
        'pdf_images',
        'order_by'
    ];

    public function legends()
    {
        return $this->hasOne(LighteningLegendInfo::class, 'fixture_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByAsc', function ($query) {
            $query->orderBy('order_by', 'asc');
        });
    }
}

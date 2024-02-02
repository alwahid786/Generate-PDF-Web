<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryFixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'part_number',
        'pdf_path',
        'image_path',
    ];
}

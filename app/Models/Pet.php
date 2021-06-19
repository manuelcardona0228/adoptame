<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'date_of_birth', 'photo_url', 'species_id', 'breed_id', 'institution_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date:mm/YYYY',
    ];
}

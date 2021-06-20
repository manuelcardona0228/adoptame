<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'date_of_birth', 'photo_url', 'species_id', 'breed_id', 'institution_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date:m/Y',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }
}

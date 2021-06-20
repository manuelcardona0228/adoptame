<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Breed extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'species_id',
    ];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }
}

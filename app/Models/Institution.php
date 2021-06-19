<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'email',
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}

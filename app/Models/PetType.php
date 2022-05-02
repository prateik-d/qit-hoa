<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pet;
use App\Models\Breed;

class PetType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'status',
        'created_at',
        'updated_at'
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function breeds()
    {
        return $this->hasMany(Breed::class);
    }
}

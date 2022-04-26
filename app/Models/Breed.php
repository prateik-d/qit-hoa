<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pet;

class Breed extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pet_type_id',
        'breed',
        'status',
        'created_at',
        'updated_at'
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}

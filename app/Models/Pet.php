<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Breed;
use App\Models\PetType;
use App\Models\PetImage;
use App\Models\User;

class Pet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'pet_type_id',
        'breed_id',
        'pet_name',
        'gender',
        'date_of_birth',
        'description',
        'allergies',
        'created_at',
        'updated_at'
    ];

    public function petType()
    {
        return $this->belongsTo(PetType::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function petImages()
    {
        return $this->hasMany(PetImage::class);
    }
}

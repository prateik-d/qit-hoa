<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pet_id',
        'img_file_path',
        'created_at',
        'updated_at'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}

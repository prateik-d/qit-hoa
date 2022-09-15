<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Amenity;

class AmenityDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amenity_id',
        'file_type',
        'file_path',
        'status'
    ];

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }
}

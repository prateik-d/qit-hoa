<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AmenityDocument;
use App\Models\Reservation;

class Amenity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'booking_price',
        'days_available',
        'timeslots'
    ];

    public function amenityDocuments()
    {
        return $this->hasMany(AmenityDocument::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
}

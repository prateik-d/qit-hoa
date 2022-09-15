<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Amenity;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amenity_id',
        'purpose',
        'description',
        'booked_by',
        'booking_date',
        'timeslots_start',
        'timeslots_end',
        'booking_price',
        'payment_mode',
        'payment_date',
        'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }
}

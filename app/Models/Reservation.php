<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ammenity_id',
        'purpose',
        'description',
        'booked_by',
        'booking_date',
        'timeslots',
        'booking_price',
        'payment_mode',
        'payment_date',
        'payment_status'
    ];
}

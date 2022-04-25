<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\EventCategory;
use App\Models\EventLocation;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_category_id',
        'organized_by',
        'event_location_id',
        'event_title',
        'event_description',
        'start_datetime',
        'end_datetime',
        'contact_phone',
        'contact_email',
        'fb_url',
        'twitter_url',
        'no_of_rsvp',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function eventLocation()
    {
        return $this->belongsTo(EventLocation::class);
    }
}

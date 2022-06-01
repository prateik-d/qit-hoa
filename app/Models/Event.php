<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\EventCategory;
use App\Models\EventPhoto;
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
        'contact_phone1',
        'contact_email1',
        'contact_phone2',
        'contact_email2',
        'contact_phone3',
        'contact_email3',
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

    public function eventImages()
    {
        return $this->hasMany(EventPhoto::class);
    }
}

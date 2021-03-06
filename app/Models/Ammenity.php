<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AmmenityDocument;

class Ammenity extends Model
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

    public function ammenityDocuments()
    {
        return $this->hasMany(AmmenityDocument::class);
    }
}

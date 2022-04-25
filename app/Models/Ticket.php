<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TicketCategory;
use App\Models\TicketImage;
use App\Models\User;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'location',
        'ticket_category_id',
        'amenities_id',
        'description',
        'created_by',
        'assigned_to',
        'date_started',
        'status',
        'created_at',
        'updated_at'
    ];

    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function ticketImages()
    {
        return $this->hasMany(TicketImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}

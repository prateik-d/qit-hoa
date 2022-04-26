<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class EventCategory extends Model
{
    use HasFactory;

    protected $table = 'event_categories';

    public $timestamps = true;

    protected $fillable = [
        'category',
        'status',
        'created_at',
        'updated_at',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}

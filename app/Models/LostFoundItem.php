<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LostFoundItemImage;

class LostFoundItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'item_title',
        'item_type',
        'category_id',
        'description',
        'date_lost',
        'date_found',
        'belongs_to',
        'found_by',
        'claimed_by',
        'date_claimed',
        'location',
        'status',
        'created_at',
        'updated_at'
    ];

    public function lostFoundItemImages()
    {
        return $this->hasMany(LostFoundItemImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

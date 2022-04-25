<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LostFoundItem;

class LostFoundItemImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lost_found_item_id',
        'file_path',
        'created_at',
        'updated_at'
    ];

    public function lostFoundItem()
    {
        return $this->belongsTo(LostFoundItem::class);
    }
}

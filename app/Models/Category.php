<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LostFoundItem;

class Category extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category',
        'description'
    ];

    public function lostFoundItems()
    {
        return $this->hasMany(LostFoundItem::class);
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // 'deleted_at' => 'datetime'
    ];

    public function insertData($request) {
        return Category::create([
            'name' => $request->name,
            'description'=>$request->description
        ]);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classified;

class ClassifiedCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category',
        'status',
        'added_by'
    ];

    public function classifiedItems()
    {
        return $this->hasMany(Classified::class);
    }
}

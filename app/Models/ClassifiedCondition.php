<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classified;

class ClassifiedCondition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'condition',
        'status',
    ];

    public function classifiedItems()
    {
        return $this->hasMany(Classified::class);
    }
}

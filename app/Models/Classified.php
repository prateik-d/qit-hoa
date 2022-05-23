<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClassifiedImage;
use App\Models\ClassifiedCategory;
use App\Models\ClassifiedCondition;

class Classified extends Model
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
        'classified_category_id',
        'classified_condition_id',
        'asking_price',
        'date_posted',
        'posted_by',
        'purchase_by',
        'sale_price',
        'status',
        'active_status',
        'added_by'
    ];

    public function classifiedImages()
    {
        return $this->hasMany(ClassifiedImage::class);
    }

    public function classifiedCategory()
    {
        return $this->belongsTo(ClassifiedCategory::class);
    }

    public function classifiedCondition()
    {
        return $this->belongsTo(ClassifiedCondition::class);
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}

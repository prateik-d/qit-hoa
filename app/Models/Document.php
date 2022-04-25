<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentCategory;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'year',
        'title',
        'type',
        'description',
        'file_path',
        'status',
        'added_by'
    ];

    public function documentCategory()
    {
        return $this->belongsTo(DocumentCategory::class);
    }
}

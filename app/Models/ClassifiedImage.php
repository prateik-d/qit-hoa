<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classified;

class ClassifiedImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'classified_id',
        'file_path'
    ];

    public function classified()
    {
        return $this->belongsTo(Classified::class);
    }
}

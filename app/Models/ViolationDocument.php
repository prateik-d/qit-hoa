<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Violation;

class ViolationDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'violation_id',
        'file_type',
        'file_path'
    ];

    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }
}

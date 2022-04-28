<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ViolationType;
use App\Models\ViolationDocument;

class Violation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'approved_by',
        'violation_type',
        'description',
        'date',
        'approved_on',
        'status',
        'created_at',
        'updated_at'
    ];

    public function violationType()
    {
        return $this->belongsTo(ViolationType::class);
    }

    public function violationDocuments()
    {
        return $this->hasMany(ViolationDocument::class);
    }
}

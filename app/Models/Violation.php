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
        'violation_type_id',
        'description',
        'violation_date',
        'approved_by',
        'moderator_commment',
        'user_reply',
        'status'
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

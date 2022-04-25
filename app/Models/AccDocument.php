<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccRequest;

class AccDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'acc_id',
        'file_type',
        'file_path',
        'created_at',
        'updated_at'
    ];

    public function accRequest()
    {
        return $this->belongsTo(AccRequest::class);
    }

    
}

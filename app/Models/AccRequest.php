<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccDocument;
use App\Models\AccRequestUser;
use App\Models\User;

class AccRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'user_id',
        'improvement_details',
        'status',
        'created_at',
        'updated_at'
    ];
    
    public function accDocuments()
    {
        return $this->hasMany(AccDocument::class, 'acc_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, AccRequestUser::class, 'acc_request_id', 'neighbour_id')->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CommitteeMember;
use App\Models\CommitteePhoto;

class Committee extends Model
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
        'year',
        'can_receive_emails',
        'added_by',
        'status'
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, CommitteeMember::class, 'committee_id', 'user_id')->withTimestamps();
    }

    public function committeePhotos()
    {
        return $this->hasMany(CommitteePhoto::class);
    }
}

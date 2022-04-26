<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VotingCategory;
use App\Models\User;

class Voting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'voting_category_id',
        'description',
        'year',
        'start_date',
        'end_date',
        'vote_option',
        'voting_winner',
        'status',
        'added_by'
    ];

    public function votingCategory()
    {
        return $this->belongsTo(VotingCategory::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, VotingNominee::class, 'voting_id', 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Voting;

class Vote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'voting_id',
        'voter_id',
        'nominee_id'
    ];

    public function voting()
    {
        return $this->belongsTo(Voting::class);
    }
}

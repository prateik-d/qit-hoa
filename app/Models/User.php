<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\AccRequest;
use App\Models\Role;
use App\Models\Event;
use App\Models\AccRequestUser;
use App\Models\LostFoundItem;
use App\Models\Ticket;
use App\Models\UserDocument;
use App\Models\Violation;
use App\Models\Vehicle;
use App\Models\Voting;
use App\Models\VotingNominee;
use App\Models\Reservation;
use App\Models\Classified;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'display_name',
        'email',
        'password',
        'remember_token',
        'role_id',
        'city_id',
        'state_id',
        'reg_code',
        'mobile_no',
        'landline_no',
        'address',
        'zip',
        'profile_pic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'organized_by');
    }

    public function userDocuments()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function accRequests()
    {
        return $this->belongsToMany(AccRequest::class, AccRequestUser::class, 'neighbour_id','acc_request_id')->withPivot('id', 'approval_status', 'neighbour_note')->withTimestamps();
    }

    public function usersAccRequests()
    {
        return $this->hasMany(AccRequest::class, 'user_id');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'owner_id');
    }

    public function usersLostFoundItems()
    {
        return $this->hasMany(LostFoundItem::class, 'belongs_to');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'owner_id');
    }

    public function committees()
    {
        return $this->belongsToMany(Committee::class, CommitteeMember::class, 'user_id','committee_id')->withPivot('id', 'added_by')->withTimestamps();
    }

    public function votings()
    {
        return $this->belongsToMany(Voting::class, VotingNominee::class, 'user_id','voting_id')->withPivot('id', 'votes_received', 'deleted_at')->withTimestamps();
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'booked_by');
    }

    public function classifieds()
    {
        return $this->hasMany(Classified::class, 'added_by');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'added_by');
    }

    public function classifiedsPostedBy()
    {
        return $this->hasMany(Classified::class, 'posted_by');
    }

    public function belongsToItem()
    {
        return $this->hasMany(LostFoundItem::class, 'belongs_to');
    }

    public function claimedBy()
    {
        return $this->hasMany(LostFoundItem::class, 'claimed_by');
    }
}

<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\GlobalStatus;
use Laravel\Sanctum\HasApiTokens; 
use Kirschbaum\PowerJoins\PowerJoins;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    //ajout du use HasRole
    use Searchable,HasApiTokens, GlobalStatus, PowerJoins,HasRoles;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function userLocalites()
    {
        return $this->hasMany(User_localite::class,'user_id','id');
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->firstname . ' ' . $this->lastname,
        );
    }

    public function cooperative()
    {
        return $this->belongsTo(Cooperative::class, 'cooperative_id');
    }


    // SCOPES
  

    public function scopeBanned()
    {
        return $this->where('status', Status::BAN_USER);
    }
    public function scopeManager($query)
    {
        $query->where('user_type', 'manager');
    }
    public function scopeStaff($query)
    {
        $query->where('user_type', '!=', 'manager');
    }
}

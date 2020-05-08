<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
/**
 * Default User model that comes pre-installed with laravel. 
 * 
 */
class User extends Authenticatable
{
    use Notifiable;


    protected $primaryKey = 'userId';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if user is an administrator
     * Note: If the user is the first user and the database and is not an admin, we make them an admin
     * @return true if user is an admin, false if user is not an admin
     */
    public function isAdmin() {
        if (sizeof(DB::table('Admin')->where('userId', '=', $this->userId)->get()) > 0 ) {
            return true;
        }
        else {
            if ($this->userId === 1) {
                DB::table('Admin')->insert(['userId' => 1]);
                return true;
            }
            else {
                return false;
            } 
        }
    }

    public function isMod() {
        if (sizeof(DB::table('Moderator')->where('userId', '=', $this->userId)->get()) > 0 ) {
            return true;
        }
        else {
            return false; 
        }
    }
}

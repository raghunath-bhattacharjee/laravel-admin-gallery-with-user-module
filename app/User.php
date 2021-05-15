<?php

namespace App;
use App\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','first_name','last_name', 'email', 'password',
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

    const ROOT_USER = 0;
    const NORMAL_USER = 1;

    const ACTIVE_USER = 1;
    const IN_ACTIVE_USER = 0;

    public function isSuperUser() {
        return self::ROOT_USER == $this->user_type;
    }

    public function isNormalUser() {
        return self::NORMAL_USER == $this->user_type;
    }

    public function isAciveUser() {
        return self::ACTIVE_USER == $this->status;
    }

    public function getPermissions() {
        return Permission::getPermissionForUser($this->role);
    }

    public function userRole() {
        $role = Permission::find($this->role);
        if ($role) {
            return $role->role;
        } else {
            return '';
        }
    }
}

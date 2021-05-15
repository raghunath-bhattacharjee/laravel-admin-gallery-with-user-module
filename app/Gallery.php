<?php

namespace App;

use App\Permission;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $casts = [
        'image_path' => 'array',
    ];

    public static function getPermissionsByRole($roleType)
    {
        return Permission::find($roleType);
    }

    public static function canView($roleType)
    {
        $role = self::getPermissionsByRole($roleType);
        if ($role) {
            return  in_array(Permission::VIEW_GALLERY, $role->permissions);
        } else {
            return false;
        }
    }

    public static function canCreate($roleType)
    {
        $role = self::getPermissionsByRole($roleType);
        if ($role) {
            return  in_array(Permission::CREATE_GALLERY, $role->permissions);
        } else {
            return false;
        }
    }

    public static function canEdit($roleType)
    {
        $role = self::getPermissionsByRole($roleType);
        if ($role) {
            return  in_array(Permission::EDIT_GALLERY, $role->permissions);
        } else {
            return false;
        }
    }

    public static function canDelete($roleType)
    {
        $role = self::getPermissionsByRole($roleType);
        if ($role) {
            return  in_array(Permission::DELETE_GALLERY, $role->permissions);
        } else {
            return false;
        }
    }
}

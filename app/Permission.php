<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public const DEFAULT = 0;
    public const VIEW_GALLERY = 1;
    public const EDIT_GALLERY = 2;
    public const CREATE_GALLERY = 3;
    public const DELETE_GALLERY = 4;

    protected $casts = [
        'permissions' => 'array',
    ];

    public function getPermissions() {
        $data = '';

        if ($this->permissions) {
            foreach ($this->permissions as $key => $permission) {
                $data .= ' ' . self::getPermissionName($permission);
            }
        }

        return $data;
    }

    public static function getPermissionName($permission)
    {
        switch ($permission) {
            case 1:
                return '<label class="badge btn-warning"> View </label>';
                break;

            case 2:
                return '<label class="badge btn-info"> Edit  </label>';
                break;

            case 3:
                return '<label class="badge btn-primary"> Create </label>';
                break;

            case 4:
                return '<label class="badge btn-danger"> Delete </label>';
                break;

            default:
                return '';
                break;
        }
    }

    public static function getPermissionForUser($roleType) {
        $role = Permission::find($roleType);

        $data = '';

        if ($role  && $role->permissions) {
            foreach ($role->permissions as $key => $permission) {
                $data .= ' ' . self::getPermissionName($permission);
            }
        }

        return $data;
    }
}


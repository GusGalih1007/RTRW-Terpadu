<?php

namespace App\Enums;

use App\Models\Role;

enum UserRoleOption
{
    case SYSAdmin;
    case Admin;
    case SubAdmin;
    case User;
    case Staff;

    public function getUuid(): string
    {
        $roleName = match($this) {
            self::SYSAdmin => 'SYSAdmin',
            self::Admin => 'Admin',
            self::SubAdmin => 'Sub-Admin',
            self::User => 'User',
            self::Staff => 'Staff',
        };

        return Role::where('roleName', $roleName)->firstOrFail()->roleId;
    }
}

<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * Проверка наличия роли пользователя
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole(... $roles ) {
//        ddd($roles);
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

}

<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Models\User;
use App\Models\Role;
use App\Services\AuthService;

class RoleService
{
    private $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Проверка на обладание пользователем роли.
     *
     * @param array $roles
     * @return bool
     */
    public function authorizeRoles(array $roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }

        throw new AccessDeniedHttpException('Insufficient rights');
    }

    public function hasAnyRole(array $roles, User $user = null)
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role, $user)) {
                return true;
            }
        }

        return false;
    }

    public function hasRole(string $role, User $user = null)
    {
        $user = $user ?? $this->auth->getUser();

        return $user->roles()->where('name', $role)->first() != null;
    }

    public function getByName(string $name): Role
    {
        $role = Role::where('name', $name)->first();

        if (!$role) {
            throw new NotFoundHttpException("Role with name '$name' not found");
        }

        return $role;
    }
}

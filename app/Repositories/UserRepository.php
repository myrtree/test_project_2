<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\RoleService;

class UserRepository
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function create(array $data): User
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $user = User::create($data);

        if (isset($data['roles'])) {
            foreach ($data['roles'] as $roleName) {
                $role = $this->roleService->getByName($roleName);
                $user->roles()->attach($role->id);
            }
        }

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $user->fill($data);
        $user->save();

        if (isset($data['roles'])) {
            $user->roles()->detach();
            foreach ($data['roles'] as $roleName) {
                $role = $this->roleService->getByName($roleName);
                $user->roles()->attach($role->id);
            }
        }

        return $user;
    }

    public function delete(User $user)
    {
//        $user->roles()->detach();
        $user->delete();
    }

    public function getById(int $id)
    {
        return User::where('id', $id)->with('roles')->first();
    }
}

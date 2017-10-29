<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\{NotFoundHttpException, BadRequestHttpException};
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Services\RoleService;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use App\Exceptions\InternalServerErrorHttpException;

class UserService
{
    private $userRepository;
    private $roleService;
    private $authService;

    public function __construct(UserRepository $userRepository, RoleService $roleService, AuthService $authService)
    {
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
        $this->authService = $authService;
    }

    public function create(array $data): User
    {
        $this->roleService->authorizeRoles(['admin', 'owner']);

        if (in_array('admin', $data['roles'])) {
            $this->roleService->authorizeRoles(['admin']);
        }

        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new InternalServerErrorHttpException('Error while adding record');
        }

        return $user;
    }

    public function getById(int $id): User
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            throw new NotFoundHttpException("User with id '$id' not found");
        }

        if (!$user->active) {
            $this->roleService->authorizeRoles(['admin', 'owner']);
        }

        return $user;
    }

    public function update(User $user, array $data)
    {
        $this->roleService->authorizeRoles(['admin', 'owner']);

        if ($this->roleService->hasRole('admin', $user)) {
            $this->roleService->authorizeRoles(['admin']);
        }

        DB::beginTransaction();
        try {
            $user = $this->userRepository->update($user, $data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new InternalServerErrorHttpException('Error while updating record');
        }

        return $user;
    }

    public function delete($user)
    {
        if ($user->id === $this->authService->getUser()->id) {
            throw new BadRequestHttpException('You can not delete yourself');
        }

        if ($this->roleService->hasAnyRole(['owner', 'admin'], $user)) {
            $this->roleService->authorizeRoles(['admin']);
        } else {
            $this->roleService->authorizeRoles(['owner']);
        }

        $this->userRepository->delete($user);
    }
}

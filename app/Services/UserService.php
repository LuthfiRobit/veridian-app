<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser(array $data)
    {
        DB::beginTransaction();
        try {
            // Hash password
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user = $this->userRepository->createUser($data);

            // Assign Roles
            if (isset($data['roles'])) {
                $user->assignRole($data['roles']);
            }

            // Log Activity
            activity()
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties(['name' => $user->name, 'email' => $user->email])
                ->log('Created User');

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateUser($id, array $data)
    {
        DB::beginTransaction();
        try {
            // Handle Password
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                $data = Arr::except($data, array('password'));
            }

            $user = $this->userRepository->updateUser($id, $data);

            // Sync Roles
            if (isset($data['roles'])) {
                $user->syncRoles($data['roles']);
            }

            // Log Activity
            activity()
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties(['name' => $user->name, 'email' => $user->email])
                ->log('Updated User');

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteUser($id)
    {
        $user = $this->userRepository->deleteUser($id);

        // Log Activity
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['name' => $user->name, 'email' => $user->email])
            ->log('Deleted User');

        return $user;
    }

    public function getUserRoles($id)
    {
        $user = $this->userRepository->getUserById($id);
        return $user->roles->pluck('name')->toArray();
    }
}

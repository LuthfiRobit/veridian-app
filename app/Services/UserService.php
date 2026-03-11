<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Storage;

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

            // Handle Avatar Upload
            if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $data['avatar'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('avatars', $filename, 'public');
                $data['avatar'] = 'storage/' . $path;
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

            // Handle Avatar Upload
            if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
                $oldUser = $this->userRepository->getUserById($id);
                if ($oldUser->avatar) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $oldUser->avatar));
                }

                $file = $data['avatar'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('avatars', $filename, 'public');
                $data['avatar'] = 'storage/' . $path;
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

    public function resetPassword($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getUserById($id);
            $this->userRepository->updateUser($id, ['password' => Hash::make('veridian1234')]);

            // Log Activity
            activity()
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties(['name' => $user->name, 'email' => $user->email])
                ->log('Reset User Password');

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getUserRoles($id)
    {
        $user = $this->userRepository->getUserById($id);
        return $user->roles->pluck('name')->toArray();
    }
}

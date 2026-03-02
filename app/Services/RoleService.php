<?php

namespace App\Services;

use App\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->getAllRoles();
    }

    public function getRoleById($id)
    {
        return $this->roleRepository->getRoleById($id);
    }

    public function createRole(array $data)
    {
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->createRole($data);

            if (isset($data['permission'])) {
                // Cast to integer to avoid Spatie name matching error
                $permissions = array_map('intval', $data['permission']);
                $this->roleRepository->syncPermissions($role, $permissions);
            }

            // Log Activity
            activity()
                ->performedOn($role)
                ->causedBy(auth()->user())
                ->withProperties(['name' => $role->name])
                ->log('Created Role');

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateRole($id, array $data)
    {
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->updateRole($id, $data);

            if (isset($data['permission'])) {
                // Cast to integer to avoid Spatie name matching error
                $permissions = array_map('intval', $data['permission']);
                $this->roleRepository->syncPermissions($role, $permissions);
            } else {
                // If no permissions are checked, sync with empty array
                $this->roleRepository->syncPermissions($role, []);
            }

            // Log Activity
            activity()
                ->performedOn($role)
                ->causedBy(auth()->user())
                ->withProperties(['name' => $role->name])
                ->log('Updated Role');

            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteRole($id)
    {
        $role = $this->roleRepository->deleteRole($id);

        // Log Activity
        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties(['name' => $role->name])
            ->log('Deleted Role');

        return $role;
    }

    public function getRolePermissions($id)
    {
        $role = $this->roleRepository->getRoleById($id);
        // Returns collection of permission IDs associated with the role
        return $role->permissions->pluck('id')->toArray();
    }
}

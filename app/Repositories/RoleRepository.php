<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAllRoles()
    {
        return Role::orderBy('id', 'DESC')->get();
    }

    public function getRoleById($id)
    {
        return Role::findOrFail($id);
    }

    public function createRole(array $data)
    {
        return Role::create(['name' => $data['name']]);
    }

    public function updateRole($id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->name = $data['name'];
        $role->save();
        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return $role;
    }

    public function syncPermissions($role, array $permissions)
    {
        $role->syncPermissions($permissions);
        return $role;
    }
}

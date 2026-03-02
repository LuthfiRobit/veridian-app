<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Http\Requests\Backend\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Role\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->roleService->getAllRoles();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('permissions', function ($row) {
                    $permissions = $row->permissions->pluck('name')->toArray();
                    $badges = '';
                    foreach ($permissions as $perm) {
                        $badges .= '<span class="badge bg-light-secondary text-secondary me-1 mb-1">' . $perm . '</span>';
                    }
                    return $badges ?: '<span class="text-muted">No Permissions</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['permissions', 'action'])
                ->make(true);
        }
        $permissions = Permission::get(); // Pass all permissions for the modal
        return view('backend.settings.roles.index', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $this->roleService->createRole($request->validated());
            return response()->json(['success' => 'Role created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $role = $this->roleService->getRoleById($id);
        $rolePermissions = $this->roleService->getRolePermissions($id);
        return response()->json([
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            $this->roleService->updateRole($id, $request->validated());
            return response()->json(['success' => 'Role updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleService->deleteRole($id);
            return response()->json(['success' => 'Role deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

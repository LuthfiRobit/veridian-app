<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\Backend\User\StoreUserRequest;
use App\Http\Requests\Backend\User\UpdateUserRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->userService->getAllUsers();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('roles', function ($row) {
                    $roles = $row->getRoleNames();
                    $badges = '';
                    foreach ($roles as $role) {
                        $badges .= '<span class="badge bg-light-primary text-primary me-1 mb-1">' . $role . '</span>';
                    }
                    return $badges ?: '<span class="text-muted">No Role</span>';
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active ? '<span class="badge bg-light-success text-success">Active</span>' : '<span class="badge bg-light-danger text-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id_user . '" class="edit btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id_user . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['roles', 'status', 'action'])
                ->make(true);
        }

        $roles = Role::pluck('name', 'name')->all();
        return view('backend.settings.users.index', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());
            return response()->json(['success' => 'User created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        $userRoles = $this->userService->getUserRoles($id);
        return response()->json([
            'user' => $user,
            'userRoles' => $userRoles
        ]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $this->userService->updateUser($id, $request->validated());
            return response()->json(['success' => 'User updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json(['success' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

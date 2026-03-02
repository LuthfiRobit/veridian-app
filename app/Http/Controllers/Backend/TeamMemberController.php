<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\TeamMemberService;
use App\Models\Language;
use App\Http\Requests\Backend\TeamMember\StoreTeamMemberRequest;
use App\Http\Requests\Backend\TeamMember\UpdateTeamMemberRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    protected $teamMemberService;

    public function __construct(TeamMemberService $teamMemberService)
    {
        $this->teamMemberService = $teamMemberService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->teamMemberService->getAllTeamMembers();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    $photo = $row->photo_path
                        ? Storage::url($row->photo_path)
                        : asset('assets/img/default-avatar.png');
                    $position = $row->getTranslated('position');
                    return '<div class="d-flex align-items-center">
                                <img src="' . $photo . '" class="rounded-circle me-3" width="40" height="40" style="object-fit:cover;" alt="Photo">
                                <div>
                                    <span class="fw-bold d-block">' . e($row->name) . '</span>
                                    <small class="text-muted">' . e($position) . '</small>
                                </div>
                            </div>';
                })
                ->addColumn('department', function ($row) {
                    return e($row->getTranslated('department'));
                })
                ->addColumn(
                    'status',
                    fn($row) => $row->is_active
                    ? '<span class="badge bg-light-success text-success">Active</span>'
                    : '<span class="badge bg-light-danger text-danger">Inactive</span>'
                )
                ->addColumn('updated_at', fn($row) => $row->updated_at?->format('d M Y') ?? '—')
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.team-members.edit', $row->id_team_member) . '" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id_team_member . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['name', 'status', 'action'])
                ->make(true);
        }

        return view('backend.team-members.index');
    }

    public function create()
    {
        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();
        return view('backend.team-members.create', compact('sortedLanguages'));
    }

    public function store(StoreTeamMemberRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo');
            }
            $this->teamMemberService->createTeamMember($data);
            return redirect()->route('admin.team-members.index')->with('success', 'Team member created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $member = $this->teamMemberService->getTeamMemberById($id);
        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();
        return view('backend.team-members.edit', compact('member', 'sortedLanguages'));
    }

    public function update(UpdateTeamMemberRequest $request, $id)
    {
        try {
            $data = $request->validated();
            // Fix: use actual select value, not has() which is always true
            $data['is_active'] = (int) $request->input('is_active', 0);
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo');
            }
            $this->teamMemberService->updateTeamMember($id, $data);
            return redirect()->route('admin.team-members.index')->with('success', 'Team member updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->teamMemberService->deleteTeamMember($id);
            return response()->json(['message' => 'Team member deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

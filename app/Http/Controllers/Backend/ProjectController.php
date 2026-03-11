<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Services\LanguageService;
use App\Models\ProjectCategory; // For dropdown
use App\Http\Requests\Backend\Project\StoreProjectRequest;
use App\Http\Requests\Backend\Project\UpdateProjectRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    protected $projectService;
    protected $languageService;

    public function __construct(ProjectService $projectService, LanguageService $languageService)
    {
        $this->projectService = $projectService;
        $this->languageService = $languageService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->projectService->getAllProjects();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return $row->getTranslated('title', '<span class="text-muted">No Title</span>');
                })
                ->addColumn('category', function ($row) {
                    if (!$row->category)
                        return '-';
                    return $row->category->getTranslated('name', '-');
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active
                        ? '<span class="badge bg-light-success text-success">Active</span>'
                        : '<span class="badge bg-light-danger text-danger">Inactive</span>';
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('Y-m-d H:i') : '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.projects.edit', $row->id_project) . '" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id_project . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Viewed Projects Management');

        return view('backend.projects.index');
    }

    public function create()
    {
        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();
        $categories = ProjectCategory::where('is_active', true)->get();

        activity()
            ->causedBy(auth()->user())
            ->log('Accessing Create Project Page');

        return view('backend.projects.create', compact('sortedLanguages', 'categories'));
    }

    public function store(StoreProjectRequest $request)
    {
        try {
            $this->projectService->createProject($request->validated());
            return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $project = $this->projectService->getProjectById($id);
        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();
        $categories = ProjectCategory::where('is_active', true)->get();

        activity()
            ->performedOn($project)
            ->causedBy(auth()->user())
            ->log('Accessing Edit Project Page');

        return view('backend.projects.edit', compact('project', 'sortedLanguages', 'categories'));
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        try {
            $this->projectService->updateProject($id, $request->validated());
            return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->projectService->deleteProject($id);
            return response()->json(['success' => 'Project deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

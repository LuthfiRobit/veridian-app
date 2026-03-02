<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Project\StoreProjectCategoryRequest;
use App\Http\Requests\Backend\Project\UpdateProjectCategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Services\LanguageService;

use Illuminate\Support\Str;

class ProjectCategoryController extends Controller
{
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProjectCategory::with('translations')->latest();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->getTranslated('name', '-');
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active
                        ? '<span class="badge bg-light-success text-success">Active</span>'
                        : '<span class="badge bg-light-danger text-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.project-categories.edit', $row->id_project_category) . '" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id_project_category . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.project_categories.index');
    }

    public function create()
    {
        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();
        return view('backend.project_categories.create', compact('sortedLanguages'));
    }

    public function store(StoreProjectCategoryRequest $request)
    {

        $category = ProjectCategory::create([
            'is_active' => $request->boolean('is_active'),
            'created_by' => auth()->id(),
        ]);

        foreach ($request->input('translations', []) as $locale => $transData) {
            if (!empty($transData['name'])) {
                if (empty($transData['slug'])) {
                    $transData['slug'] = Str::slug($transData['name']);
                }
                $category->translateOrNew($locale)->fill($transData);
            }
        }
        $category->save();

        return redirect()->route('admin.project-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = ProjectCategory::findOrFail($id);
        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();
        return view('backend.project_categories.edit', compact('category', 'sortedLanguages'));
    }

    public function update(UpdateProjectCategoryRequest $request, $id)
    {
        $category = ProjectCategory::findOrFail($id);
        $category->update([
            'is_active' => $request->boolean('is_active'),
            'updated_by' => auth()->id(),
        ]);

        foreach ($request->input('translations', []) as $locale => $transData) {
            if (!empty($transData['name'])) {
                if (empty($transData['slug'])) {
                    $transData['slug'] = Str::slug($transData['name']);
                }
                $category->translateOrNew($locale)->fill($transData);
            }
        }
        $category->save();

        return redirect()->route('admin.project-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = ProjectCategory::findOrFail($id);
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}

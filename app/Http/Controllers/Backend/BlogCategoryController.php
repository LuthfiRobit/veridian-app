<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Blog\StoreBlogCategoryRequest;
use App\Http\Requests\Backend\Blog\UpdateBlogCategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Services\LanguageService;
use App\Repositories\BlogCategoryRepository;
use App\Services\BlogCategoryService;

class BlogCategoryController extends Controller
{
    protected $languageService;
    protected $repository;
    protected $service;

    public function __construct(LanguageService $languageService, BlogCategoryRepository $repository, BlogCategoryService $service)
    {
        $this->languageService = $languageService;
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->repository->getForDataTable();
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
                ->addColumn('badge_color', function ($row) {
                    if (!$row->badge_color)
                        return '-';
                    return '<span class="badge" style="background-color: #f0f0f0; color: #333;">' . e($row->badge_color) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id_blog_category . '" class="btn btn-icon btn-light-primary btn-sm btn-edit" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id_blog_category . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status', 'badge_color', 'action'])
                ->make(true);
        }

        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();

        return view('backend.blog.categories.index', compact('sortedLanguages'));
    }

    public function store(StoreBlogCategoryRequest $request)
    {
        $this->service->createCategory($request->validated());
        return response()->json(['success' => 'Blog Category created successfully.']);
    }

    public function edit(BlogCategory $blog_category)
    {
        $blog_category->load('translations');
        return response()->json($blog_category);
    }

    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blog_category)
    {
        $this->service->updateCategory($blog_category, $request->validated());
        return response()->json(['success' => 'Blog Category updated successfully.']);
    }

    public function destroy(BlogCategory $blog_category)
    {
        $this->service->deleteCategory($blog_category);
        return response()->json(['success' => 'Blog Category deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Blog\StoreBlogPostRequest;
use App\Http\Requests\Backend\Blog\UpdateBlogPostRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Services\LanguageService;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Services\BlogPostService;
use Carbon\Carbon;

class BlogPostController extends Controller
{
    protected $languageService;
    protected $repository;
    protected $categoryRepository;
    protected $service;

    public function __construct(LanguageService $languageService, BlogPostRepository $repository, BlogCategoryRepository $categoryRepository, BlogPostService $service)
    {
        $this->languageService = $languageService;
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->repository->getForDataTable();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return $row->getTranslated('title', '-');
                })
                ->addColumn('category', function ($row) {
                    if (!$row->category)
                        return '-';
                    return $row->category->getTranslated('name', '-');
                })
                ->addColumn('author', function ($row) {
                    return $row->author ? ($row->author->name ?? '-') : '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'published'
                        ? '<span class="badge bg-light-success text-success">Published</span>'
                        : '<span class="badge bg-light-warning text-warning">Draft</span>';
                })
                ->addColumn('published_at', function ($row) {
                    return $row->published_at ? \Carbon\Carbon::parse($row->published_at)->format('d M Y H:i') : '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.blog-posts.edit', $row->id_blog_post) . '" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id_blog_post . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.blog.posts.index');
    }

    public function create()
    {
        $categories = $this->categoryRepository->getActiveForDropdown();
        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();

        return view('backend.blog.posts.create', compact('categories', 'sortedLanguages'));
    }

    public function store(StoreBlogPostRequest $request)
    {
        $this->service->createPost($request->validated());
        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog Post created successfully.');
    }

    public function edit(BlogPost $blog_post)
    {
        $post = $blog_post;
        $categories = $this->categoryRepository->getActiveForDropdown();
        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();

        return view('backend.blog.posts.edit', compact('post', 'categories', 'sortedLanguages'));
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blog_post)
    {
        $this->service->updatePost($blog_post, $request->validated());
        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog Post updated successfully.');
    }

    public function destroy(BlogPost $blog_post)
    {
        $this->service->deletePost($blog_post);
        return response()->json(['success' => 'Blog Post deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\TestimonialService;
use App\Models\Language;
use App\Models\Project;
use App\Http\Requests\Backend\Testimonial\StoreTestimonialRequest;
use App\Http\Requests\Backend\Testimonial\UpdateTestimonialRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->testimonialService->getAllTestimonials();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('client_name', function ($row) {
                    $avatar = $row->avatar_path
                        ? \Illuminate\Support\Facades\Storage::url($row->avatar_path)
                        : asset('assets/img/default-avatar.png');
                    $clientPosition = $row->getTranslated('client_position', '');
                    return '<div class="d-flex align-items-center">
                                <img src="' . $avatar . '" class="rounded-circle me-3" width="40" height="40" alt="Avatar" style="object-fit:cover;">
                                <div>
                                    <span class="fw-bold d-block">' . e($row->client_name) . '</span>
                                    <small class="text-muted">' . e($clientPosition) . '</small>
                                </div>
                            </div>';
                })
                ->addColumn('rating', function ($row) {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= (int) $row->rating) {
                            $stars .= '<i class="ti ti-star text-warning"></i>';
                        } else {
                            $stars .= '<i class="ti ti-star text-muted"></i>';
                        }
                    }
                    return $stars . ' <small class="text-muted ms-1">' . (int) $row->rating . '/5</small>';
                })
                ->addColumn('project', function ($row) {
                    if (!$row->project)
                        return '<span class="text-muted">—</span>';
                    $projTitle = $row->project->getTranslated('title', '—');
                    return '<span class="badge bg-light-primary text-primary">' . e($projTitle) . '</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge bg-light-success text-success">Active</span>';
                    }
                    return '<span class="badge bg-light-danger text-danger">Inactive</span>';
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('d M Y') : '—';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.testimonials.edit', $row->id_testimonial);
                    $btn = '<a href="' . $editUrl . '" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id_testimonial . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['client_name', 'rating', 'project', 'status', 'action'])
                ->make(true);
        }

        return view('backend.testimonials.index');
    }

    public function create()
    {
        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();
        $projects = Project::where('is_active', true)->orderBy('sort_order')->get();
        return view('backend.testimonials.create', compact('sortedLanguages', 'projects'));
    }

    public function store(StoreTestimonialRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar');
            }
            $this->testimonialService->createTestimonial($data);
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create testimonial: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $testimonial = $this->testimonialService->getTestimonialById($id);
        } catch (\Exception $e) {
            return redirect()->route('admin.testimonials.index')->with('error', 'Testimonial not found.');
        }

        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();
        $projects = Project::where('is_active', true)->orderBy('sort_order')->get();

        return view('backend.testimonials.edit', compact('testimonial', 'sortedLanguages', 'projects'));
    }

    public function update(UpdateTestimonialRequest $request, $id)
    {
        try {
            $data = $request->validated();
            // Fix: use actual select value, not has() which is always true for a select
            $data['is_active'] = (int) $request->input('is_active', 0);
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar');
            }
            $this->testimonialService->updateTestimonial($id, $data);
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update testimonial: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->testimonialService->deleteTestimonial($id);
            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Testimonial deleted successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'Testimonial not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete testimonial: ' . $e->getMessage()], 500);
        }
    }
}

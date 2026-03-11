<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\CompanyTimelineService;
use App\Models\Language;
use App\Http\Requests\Backend\CompanyTimeline\StoreCompanyTimelineRequest;
use App\Http\Requests\Backend\CompanyTimeline\UpdateCompanyTimelineRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyTimelineController extends Controller
{
    protected $service;

    public function __construct(CompanyTimelineService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->getAll();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('year_display', function ($row) {
                    return '<span class="badge bg-light-primary text-primary fw-bold">' . e($row->year) . '</span>';
                })
                ->addColumn('title', function ($row) {
                    $title = $row->getTranslated('title', '—');
                    $icon = $row->icon_class ? '<i class="' . e($row->icon_class) . ' me-2"></i>' : '';
                    return $icon . e($title);
                })
                ->addColumn('description', function ($row) {
                    $desc = $row->getTranslated('description', '—');
                    return \Illuminate\Support\Str::limit(strip_tags($desc), 60);
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge bg-light-success text-success">Active</span>';
                    }
                    return '<span class="badge bg-light-danger text-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.company-timelines.edit', $row->id_company_timeline);
                    $btn = '<a href="' . $editUrl . '" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id_company_timeline . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['year_display', 'title', 'status', 'action'])
                ->make(true);
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Viewed Company Timeline Management');

        return view('backend.company-timelines.index');
    }

    public function create()
    {
        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();
        activity()
            ->causedBy(auth()->user())
            ->log('Accessing Create Company Timeline Page');

        return view('backend.company-timelines.create', compact('sortedLanguages'));
    }

    public function store(StoreCompanyTimelineRequest $request)
    {
        try {
            $data = $request->validated();
            $this->service->create($data);
            return redirect()->route('admin.company-timelines.index')->with('success', 'Timeline milestone created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create timeline: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $timeline = $this->service->findById($id);
        } catch (\Exception $e) {
            return redirect()->route('admin.company-timelines.index')->with('error', 'Timeline not found.');
        }

        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();
        activity()
            ->performedOn($timeline)
            ->causedBy(auth()->user())
            ->log('Accessing Edit Company Timeline Page');

        return view('backend.company-timelines.edit', compact('timeline', 'sortedLanguages'));
    }

    public function update(UpdateCompanyTimelineRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = (int) $request->input('is_active', 0);
            $this->service->update($id, $data);
            return redirect()->route('admin.company-timelines.index')->with('success', 'Timeline milestone updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update timeline: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->service->delete($id);
            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Timeline milestone deleted successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'Timeline not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete timeline: ' . $e->getMessage()], 500);
        }
    }
}

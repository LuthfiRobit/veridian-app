<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\CoreValueService;
use App\Models\Language;
use App\Http\Requests\Backend\CoreValue\StoreCoreValueRequest;
use App\Http\Requests\Backend\CoreValue\UpdateCoreValueRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoreValueController extends Controller
{
    protected $coreValueService;

    public function __construct(CoreValueService $coreValueService)
    {
        $this->coreValueService = $coreValueService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->coreValueService->getAllCoreValues();

            return DataTables::of($data)
                ->addIndexColumn()
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
                    $editUrl = route('admin.core-values.edit', $row->id_core_value);
                    $btn = '<a href="' . $editUrl . '" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id_core_value . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['title', 'status', 'action'])
                ->make(true);
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Viewed Core Values Management');

        return view('backend.core-values.index');
    }

    public function create()
    {
        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();
        activity()
            ->causedBy(auth()->user())
            ->log('Accessing Create Core Value Page');

        return view('backend.core-values.create', compact('sortedLanguages'));
    }

    public function store(StoreCoreValueRequest $request)
    {
        try {
            $data = $request->validated();
            $this->coreValueService->createCoreValue($data);
            return redirect()->route('admin.core-values.index')->with('success', 'Core value created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create core value: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $coreValue = $this->coreValueService->getCoreValueById($id);
        } catch (\Exception $e) {
            return redirect()->route('admin.core-values.index')->with('error', 'Core value not found.');
        }

        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();
        activity()
            ->performedOn($coreValue)
            ->causedBy(auth()->user())
            ->log('Accessing Edit Core Value Page');

        return view('backend.core-values.edit', compact('coreValue', 'sortedLanguages'));
    }

    public function update(UpdateCoreValueRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = (int) $request->input('is_active', 0);
            $this->coreValueService->updateCoreValue($id, $data);
            return redirect()->route('admin.core-values.index')->with('success', 'Core value updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update core value: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->coreValueService->deleteCoreValue($id);
            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Core value deleted successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'Core value not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete core value: ' . $e->getMessage()], 500);
        }
    }
}

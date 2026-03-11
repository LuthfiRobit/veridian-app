<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use App\Services\LanguageService; // To get active languages
use App\Http\Requests\Backend\Service\StoreServiceRequest;
use App\Http\Requests\Backend\Service\UpdateServiceRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    protected $serviceService;
    protected $languageService;

    public function __construct(ServiceService $serviceService, LanguageService $languageService)
    {
        $this->serviceService = $serviceService;
        $this->languageService = $languageService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->serviceService->getAllServices();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->getTranslated('name', '<span class="text-muted">No Name</span>');
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
                    $btn = '<a href="' . route('admin.services.edit', $row->id_service) . '" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id_service . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['name', 'status', 'action'])
                ->make(true);
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Viewed Services Management');

        return view('backend.services.index');
    }

    public function create()
    {
        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();

        activity()
            ->causedBy(auth()->user())
            ->log('Accessing Create Service Page');

        return view('backend.services.create', compact('sortedLanguages'));
    }

    public function store(StoreServiceRequest $request)
    {
        try {
            $this->serviceService->createService($request->validated());
            return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $service = $this->serviceService->getServiceById($id);
        $sortedLanguages = $this->languageService->getAllLanguages()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->get();

        activity()
            ->performedOn($service)
            ->causedBy(auth()->user())
            ->log('Accessing Edit Service Page');

        return view('backend.services.edit', compact('service', 'sortedLanguages'));
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        try {
            $this->serviceService->updateService($id, $request->validated());
            return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->serviceService->deleteService($id);
            return response()->json(['success' => 'Service deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

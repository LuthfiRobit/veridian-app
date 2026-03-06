<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\LanguageService;
use App\Http\Requests\Backend\Language\StoreLanguageRequest;
use App\Http\Requests\Backend\Language\UpdateLanguageRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LanguageController extends Controller
{
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->languageService->getAllLanguages();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id_language . '" class="edit btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id_language . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('is_default', function ($row) {
                    if ($row->is_default) {
                        return '<div class="form-check form-switch d-flex justify-content-center"><input class="form-check-input" type="checkbox" checked disabled style="cursor: not-allowed;" title="Already Default"></div>';
                    } else {
                        return '<div class="form-check form-switch d-flex justify-content-center"><input class="form-check-input set-default-btn" type="checkbox" data-id="' . $row->id_language . '" title="Set as Default"></div>';
                    }
                })
                ->addColumn('icon_display', function ($row) {
                    return '<i class="' . $row->icon . '"></i> ' . $row->icon;
                })
                ->rawColumns(['action', 'status', 'icon_display', 'is_default'])
                ->make(true);
        }
        return view('backend.settings.languages.index');
    }

    public function store(StoreLanguageRequest $request)
    {
        try {
            $this->languageService->createLanguage($request->validated());
            return response()->json(['success' => 'Language created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $language = $this->languageService->getLanguageById($id);
        return response()->json($language);
    }

    public function update(UpdateLanguageRequest $request, $id)
    {
        try {
            $this->languageService->updateLanguage($id, $request->validated());
            return response()->json(['success' => 'Language updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->languageService->deleteLanguage($id);
            return response()->json(['success' => 'Language deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function setDefault($id)
    {
        try {
            app(\App\Interfaces\LanguageRepositoryInterface::class)->setDefault($id);
            \App\Models\Language::clearDefaultCodeCache();
            return response()->json(['success' => 'Default language updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

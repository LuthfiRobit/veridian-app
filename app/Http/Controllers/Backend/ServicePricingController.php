<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServicePricing;
use App\Http\Requests\Backend\Service\StoreServicePricingRequest;
use App\Http\Requests\Backend\Service\UpdateServicePricingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServicePricingController extends Controller
{
    public function index(Service $service)
    {
        $query = $service->pricings()->with('translations')->orderBy('sort_order');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-icon btn-light-warning btn-sm edit-pricing" data-id="' . $row->id_service_pricing . '" title="Edit"><i class="ti ti-edit"></i></button>';
                $btn .= ' <button type="button" class="btn btn-icon btn-light-danger btn-sm delete-pricing" data-id="' . $row->id_service_pricing . '" title="Delete"><i class="ti ti-trash"></i></button>';
                return $btn;
            })
            ->editColumn('is_featured', function ($row) {
                return $row->is_featured ? '<span class="badge bg-primary">Popular</span>' : '-';
            })
            ->rawColumns(['action', 'is_featured'])
            ->make(true);
    }

    public function store(StoreServicePricingRequest $request, Service $service)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $this->extractTranslations($data);

            $pricing = $service->pricings()->create($data);
            $this->saveTranslations($pricing, $translations);

            DB::commit();
            return response()->json(['success' => 'Pricing plan added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Service $service, ServicePricing $pricing)
    {
        $pricing->load('translations');
        return response()->json($pricing);
    }

    public function update(UpdateServicePricingRequest $request, Service $service, ServicePricing $pricing)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $this->extractTranslations($data);

            $pricing->update($data);
            $this->saveTranslations($pricing, $translations);

            DB::commit();
            return response()->json(['success' => 'Pricing plan updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Service $service, ServicePricing $pricing)
    {
        try {
            $pricing->delete();
            return response()->json(['success' => 'Pricing plan deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function extractTranslations(&$data)
    {
        $translations = [];
        if (isset($data['translations'])) {
            foreach ($data['translations'] as $locale => $transData) {
                if (!empty($transData['name'])) {
                    // Handle Features List: Convert textarea newlines to array
                    if (isset($transData['features_raw'])) {
                        $raw = $transData['features_raw'];
                        // Split by newline, trim whitespace, filter empty lines
                        $features = array_filter(array_map('trim', explode("\n", $raw)));
                        $transData['features_list'] = array_values($features);
                        unset($transData['features_raw']);
                    }

                    $translations[$locale] = $transData;
                }
            }
            unset($data['translations']);
        }
        return $translations;
    }

    private function saveTranslations($model, $translations)
    {
        foreach ($translations as $locale => $transData) {
            $model->translateOrNew($locale)->fill($transData);
        }
        $model->save();
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceBenefit;
use App\Http\Requests\Backend\Service\StoreServiceBenefitRequest;
use App\Http\Requests\Backend\Service\UpdateServiceBenefitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServiceBenefitController extends Controller
{
    public function index(Service $service)
    {
        $query = $service->benefits()->with('translations');

        // The activity log was already present and is kept as per instruction to "keep only one".
        // If there was a duplicate, it would have been removed.
        activity()
            ->performedOn($service)
            ->causedBy(auth()->user())
            ->log('Fetched Service Benefits for ' . $service->getTranslated('title'));

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($service) {
                $btn = '<button type="button" class="btn btn-icon btn-light-warning btn-sm edit-benefit" data-id="' . $row->id_service_benefit . '" title="Edit"><i class="ti ti-edit"></i></button>';
                $btn .= ' <button type="button" class="btn btn-icon btn-light-danger btn-sm delete-benefit" data-id="' . $row->id_service_benefit . '" title="Delete"><i class="ti ti-trash"></i></button>';
                return $btn;
            })
            ->addColumn('icon_display', function ($row) {
                return $row->icon_class ? '<i class="' . $row->icon_class . '"></i> ' . $row->icon_class : '-';
            })
            ->rawColumns(['action', 'icon_display'])
            ->make(true);
    }

    public function store(StoreServiceBenefitRequest $request, Service $service)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $translations = $this->filterTranslations($data['translations'] ?? []);
            unset($data['translations']);

            $benefit = $service->benefits()->create($data);

            foreach ($translations as $locale => $transData) {
                $benefit->translateOrNew($locale)->fill($transData);
            }
            $benefit->save();

            DB::commit();

            return response()->json(['success' => 'Benefit added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Service $service, ServiceBenefit $benefit)
    {
        $benefit->load('translations');
        return response()->json($benefit);
    }

    public function update(UpdateServiceBenefitRequest $request, Service $service, ServiceBenefit $benefit)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $translations = $this->filterTranslations($data['translations'] ?? []);
            unset($data['translations']);

            $benefit->update($data);

            foreach ($translations as $locale => $transData) {
                $benefit->translateOrNew($locale)->fill($transData);
            }
            $benefit->save();

            DB::commit();

            return response()->json(['success' => 'Benefit updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Filter translations to remove empty entries.
     */
    private function filterTranslations(array $translations)
    {
        return array_filter($translations, function ($transData) {
            return !empty($transData['title']);
        });
    }

    public function destroy(Service $service, ServiceBenefit $benefit)
    {
        try {
            $benefit->delete();

            activity()
                ->performedOn($benefit)
                ->causedBy(auth()->user())
                ->log('Deleted Service Benefit');

            return response()->json(['success' => 'Benefit deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

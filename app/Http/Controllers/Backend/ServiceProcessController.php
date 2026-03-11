<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceProcess;
use App\Http\Requests\Backend\Service\StoreServiceProcessRequest;
use App\Http\Requests\Backend\Service\UpdateServiceProcessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServiceProcessController extends Controller
{
    public function index(Service $service)
    {
        $query = $service->processes()->with('translations')->orderBy('step_number');

        activity()
            ->performedOn($service)
            ->causedBy(auth()->user())
            ->log('Fetched Service Process Steps for ' . $service->getTranslated('title'));

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-icon btn-light-warning btn-sm edit-process" data-id="' . $row->id_service_process . '" title="Edit"><i class="ti ti-edit"></i></button>';
                $btn .= ' <button type="button" class="btn btn-icon btn-light-danger btn-sm delete-process" data-id="' . $row->id_service_process . '" title="Delete"><i class="ti ti-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(StoreServiceProcessRequest $request, Service $service)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $this->extractTranslations($data);

            $process = $service->processes()->create($data);
            $this->saveTranslations($process, $translations);

            DB::commit();

            activity()
                ->performedOn($process)
                ->causedBy(auth()->user())
                ->log('Added Process Step to Service');

            return response()->json(['success' => 'Process step added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Service $service, ServiceProcess $process)
    {
        $process->load('translations');
        return response()->json($process);
    }

    public function update(UpdateServiceProcessRequest $request, Service $service, ServiceProcess $process)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $this->extractTranslations($data);

            $process->update($data);
            $this->saveTranslations($process, $translations);

            DB::commit();

            activity()
                ->performedOn($process)
                ->causedBy(auth()->user())
                ->log('Updated Service Process Step');

            return response()->json(['success' => 'Process step updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Service $service, ServiceProcess $process)
    {
        try {
            $process->delete();

            activity()
                ->performedOn($process)
                ->causedBy(auth()->user())
                ->log('Deleted Service Process Step');

            return response()->json(['success' => 'Process step deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function extractTranslations(&$data)
    {
        $translations = [];
        if (isset($data['translations'])) {
            foreach ($data['translations'] as $locale => $transData) {
                if (!empty($transData['title'])) {
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

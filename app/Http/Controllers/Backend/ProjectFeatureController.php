<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectFeature;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Project\StoreProjectFeatureRequest;
use App\Http\Requests\Backend\Project\UpdateProjectFeatureRequest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProjectFeatureController extends Controller
{
    public function index(Project $project)
    {
        $query = $project->features()->with('translations');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($project) {
                activity()
                    ->performedOn($project)
                    ->causedBy(auth()->user())
                    ->log('Fetched Project Features for ' . $project->getTranslated('title'));
                $btn = '<button type="button" class="btn btn-icon btn-light-warning btn-sm edit-feature" data-id="' . $row->id_project_feature . '" title="Edit"><i class="ti ti-edit"></i></button>';
                $btn .= ' <button type="button" class="btn btn-icon btn-light-danger btn-sm delete-feature" data-id="' . $row->id_project_feature . '" title="Delete"><i class="ti ti-trash"></i></button>';
                return $btn;
            })
            ->make(true);
    }

    public function store(StoreProjectFeatureRequest $request, Project $project)
    {
        try {
            DB::beginTransaction();

            $feature = $project->features()->create([
                'icon_class' => $request->input('icon_class'),
                'sort_order' => $request->input('sort_order', 0),
            ]);

            foreach ($request->input('translations', []) as $locale => $transData) {
                if (!empty($transData['title'])) {
                    $feature->translateOrNew($locale)->fill($transData);
                }
            }
            $feature->save();

            DB::commit();
            return response()->json(['success' => 'Feature added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Project $project, ProjectFeature $feature)
    {
        if ($feature->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        $feature->load('translations');
        return response()->json($feature);
    }

    public function update(UpdateProjectFeatureRequest $request, Project $project, ProjectFeature $feature)
    {
        if ($feature->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $feature->update([
                'icon_class' => $request->input('icon_class'),
                'sort_order' => $request->input('sort_order'),
            ]);

            foreach ($request->input('translations', []) as $locale => $transData) {
                if (!empty($transData['title'])) {
                    $feature->translateOrNew($locale)->fill($transData);
                }
            }
            $feature->save();

            DB::commit();
            return response()->json(['success' => 'Feature updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Project $project, ProjectFeature $feature)
    {
        if ($feature->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        $feature->delete();

        activity()
            ->performedOn($feature)
            ->causedBy(auth()->user())
            ->log('Deleted Project Feature');

        return response()->json(['success' => 'Feature deleted successfully.']);
    }
}

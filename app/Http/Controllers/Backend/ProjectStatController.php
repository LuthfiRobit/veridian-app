<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectStat;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Project\StoreProjectStatRequest;
use App\Http\Requests\Backend\Project\UpdateProjectStatRequest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProjectStatController extends Controller
{
    public function index(Project $project)
    {
        $query = $project->stats()->with('translations');

        activity()
            ->performedOn($project)
            ->causedBy(auth()->user())
            ->log('Fetched Project Statistics for ' . $project->getTranslated('title'));

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-icon btn-light-warning btn-sm edit-stat" data-id="' . $row->id_project_stat . '" title="Edit"><i class="ti ti-edit"></i></button>';
                $btn .= ' <button type="button" class="btn btn-icon btn-light-danger btn-sm delete-stat" data-id="' . $row->id_project_stat . '" title="Delete"><i class="ti ti-trash"></i></button>';
                return $btn;
            })
            ->make(true);
    }

    public function store(StoreProjectStatRequest $request, Project $project)
    {
        try {
            DB::beginTransaction();

            $stat = $project->stats()->create([
                'value' => $request->input('value'),
                'icon_class' => $request->input('icon_class'),
                'sort_order' => $request->input('sort_order', 0),
            ]);

            foreach ($request->input('translations', []) as $locale => $transData) {
                if (!empty($transData['label'])) {
                    $stat->translateOrNew($locale)->fill($transData);
                }
            }
            $stat->save();

            activity()
                ->performedOn($stat)
                ->causedBy(auth()->user())
                ->log('Added Statistic to Project');

            DB::commit();
            return response()->json(['success' => 'Stat added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Project $project, ProjectStat $stat)
    {
        if ($stat->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        $stat->load('translations');
        return response()->json($stat);
    }

    public function update(UpdateProjectStatRequest $request, Project $project, ProjectStat $stat)
    {
        if ($stat->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $stat->update([
                'value' => $request->input('value'),
                'icon_class' => $request->input('icon_class'),
                'sort_order' => $request->input('sort_order'),
            ]);

            foreach ($request->input('translations', []) as $locale => $transData) {
                if (!empty($transData['label'])) {
                    $stat->translateOrNew($locale)->fill($transData);
                }
            }
            $stat->save();

            activity()
                ->performedOn($stat)
                ->causedBy(auth()->user())
                ->log('Updated Project Statistic');

            DB::commit();
            return response()->json(['success' => 'Stat updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Project $project, ProjectStat $stat)
    {
        if ($stat->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        $stat->delete();

        activity()
            ->performedOn($stat)
            ->causedBy(auth()->user())
            ->log('Deleted Project Statistic');

        return response()->json(['success' => 'Stat deleted successfully.']);
    }
}

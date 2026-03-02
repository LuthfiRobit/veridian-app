<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Project\StoreProjectImageRequest;
use App\Http\Requests\Backend\Project\UpdateProjectImageRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProjectImageController extends Controller
{
    public function index(Project $project)
    {
        $query = $project->images()->with('translations');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<img src="' . asset($row->image_path) . '" style="width: 50px; height: 50px; object-fit: cover;">';
            })
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-icon btn-light-warning btn-sm edit-image" data-id="' . $row->id_project_image . '" title="Edit"><i class="ti ti-edit"></i></button>';
                $btn .= ' <button type="button" class="btn btn-icon btn-light-danger btn-sm delete-image" data-id="' . $row->id_project_image . '" title="Delete"><i class="ti ti-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function store(StoreProjectImageRequest $request, Project $project)
    {
        try {
            DB::beginTransaction();

            $path = $request->file('image_path')->store('project_images', 'public');

            $image = $project->images()->create([
                'image_path' => 'storage/' . $path,
                'is_hero' => $request->boolean('is_hero'),
                'sort_order' => $request->input('sort_order', 0),
            ]);

            foreach ($request->input('translations', []) as $locale => $transData) {
                if (!empty($transData['caption'])) {
                    $image->translateOrNew($locale)->fill($transData);
                }
            }
            $image->save();

            DB::commit();
            return response()->json(['success' => 'Image added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Project $project, ProjectImage $image)
    {
        if ($image->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        $image->load('translations');
        return response()->json($image);
    }

    public function update(UpdateProjectImageRequest $request, Project $project, ProjectImage $image)
    {
        if ($image->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('image_path')) {
                // Delete old image
                if ($image->image_path) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));
                }
                $path = $request->file('image_path')->store('project_images', 'public');
                $image->image_path = 'storage/' . $path;
            }

            $image->update([
                'is_hero' => $request->boolean('is_hero'),
                'sort_order' => $request->input('sort_order'),
            ]);

            foreach ($request->input('translations', []) as $locale => $transData) {
                if (!empty($transData['caption'])) {
                    $image->translateOrNew($locale)->fill($transData);
                }
            }
            $image->save();

            DB::commit();
            return response()->json(['success' => 'Image updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        if ($image->project_id != $project->id_project) {
            abort(403, 'Unauthorized action.');
        }

        try {
            if ($image->image_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));
            }
            $image->delete();
            return response()->json(['success' => 'Image deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

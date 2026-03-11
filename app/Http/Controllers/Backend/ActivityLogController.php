<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::with('causer')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('log_name', function ($row) {
                    return '<span class="badge bg-light-primary text-primary">' . e($row->log_name) . '</span>';
                })
                ->addColumn('description', function ($row) {
                    return e($row->description);
                })
                ->addColumn('causer', function ($row) {
                    if ($row->causer) {
                        return '<div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">' . e($row->causer->name) . '</h6>
                                        <span class="text-muted text-sm">' . e($row->causer->email) . '</span>
                                    </div>
                                </div>';
                    }
                    return '<span class="text-muted">System</span>';
                })
                ->addColumn('properties', function ($row) {
                    $props = json_encode($row->properties);
                    return '<button type="button" class="btn btn-sm btn-light-info view-properties" data-properties=\'' . htmlspecialchars($props, ENT_QUOTES, 'UTF-8') . '\'><i class="ti ti-eye"></i> View</button>';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '-';
                })
                ->rawColumns(['log_name', 'causer', 'properties'])
                ->make(true);
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Viewed Activity Logs Management');

        return view('backend.settings.activity_logs.index');
    }
}

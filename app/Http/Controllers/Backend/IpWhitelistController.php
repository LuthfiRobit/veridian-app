<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\IpWhitelistService;
use App\Http\Requests\Backend\IpWhitelist\StoreIpWhitelistRequest;
use App\Http\Requests\Backend\IpWhitelist\UpdateIpWhitelistRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IpWhitelistController extends Controller
{
    protected $ipWhitelistService;

    public function __construct(IpWhitelistService $ipWhitelistService)
    {
        $this->ipWhitelistService = $ipWhitelistService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->ipWhitelistService->getAllIpWhitelists();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id_ip_whitelist . '" class="edit btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id_ip_whitelist . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active ? '<span class="badge bg-light-success text-success">Active</span>' : '<span class="badge bg-light-danger text-danger">Inactive</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('backend.settings.ip_whitelists.index');
    }

    public function store(StoreIpWhitelistRequest $request)
    {
        try {
            $this->ipWhitelistService->createIpWhitelist($request->validated());
            return response()->json(['success' => 'IP Whitelist created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $ip = $this->ipWhitelistService->getIpWhitelistById($id);
        return response()->json($ip);
    }

    public function update(UpdateIpWhitelistRequest $request, $id)
    {
        try {
            $this->ipWhitelistService->updateIpWhitelist($id, $request->validated());
            return response()->json(['success' => 'IP Whitelist updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->ipWhitelistService->deleteIpWhitelist($id);
            return response()->json(['success' => 'IP Whitelist deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

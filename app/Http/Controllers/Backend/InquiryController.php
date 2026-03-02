<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\InquiryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InquiryController extends Controller
{
    protected $inquiryService;

    public function __construct(InquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->inquiryService->getAllInquiries();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sender', function ($row) {
                    $readClass = $row->is_read ? '' : 'fw-bold';
                    return '<div>
                                <span class="d-block ' . $readClass . '">' . e($row->name) . '</span>
                                <small class="text-muted">' . e($row->email) . '</small>
                            </div>';
                })
                ->addColumn('subject', function ($row) {
                    $readClass = $row->is_read ? '' : 'fw-bold';
                    return '<span class="' . $readClass . '">' . e($row->subject) . '</span>';
                })
                ->addColumn('service', function ($row) {
                    if (!$row->service)
                        return '<span class="text-muted">—</span>';
                    return '<span class="badge bg-light-info text-info">' . e($row->service) . '</span>';
                })
                ->addColumn('status', function ($row) {
                    return $row->is_read
                        ? '<span class="badge bg-light-secondary text-secondary">Read</span>'
                        : '<span class="badge bg-light-primary text-primary">New</span>';
                })
                ->addColumn('date', function ($row) {
                    return $row->created_at?->format('d M Y H:i') ?? '—';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.inquiries.show', $row->id_inquiry) . '" class="btn btn-icon btn-light-primary btn-sm" title="View"><i class="ti ti-eye"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id_inquiry . '" class="btn btn-icon btn-light-danger btn-sm btn-delete" title="Delete"><i class="ti ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['sender', 'subject', 'service', 'status', 'action'])
                ->make(true);
        }

        return view('backend.inquiries.index');
    }

    public function show($id)
    {
        $inquiry = $this->inquiryService->getInquiryById($id);
        $this->inquiryService->markAsRead($id);

        return view('backend.inquiries.show', compact('inquiry'));
    }

    public function destroy($id)
    {
        try {
            $this->inquiryService->deleteInquiry($id);
            return response()->json(['message' => 'Inquiry deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

@extends('layouts.backend')
@section('title', 'View Inquiry')

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header-title">
                        <h5 class="m-b-10">View Inquiry</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inquiries.index') }}">Inquiries</a></li>
                        <li class="breadcrumb-item">View</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Message Content --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5><i class="ti ti-mail me-2"></i>{{ $inquiry->subject }}</h5>
                    @if($inquiry->service)
                        <span class="badge bg-light-info text-info">{{ $inquiry->service }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="p-3 bg-light rounded mb-0" style="white-space: pre-wrap; line-height: 1.8;">
                        {{ $inquiry->message }}</div>
                </div>
            </div>
        </div>

        {{-- Sender Details --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Sender Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Name</label>
                        <div class="fw-bold">{{ $inquiry->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Email</label>
                        <div>
                            <a href="mailto:{{ $inquiry->email }}" class="text-primary">
                                <i class="ti ti-mail me-1"></i>{{ $inquiry->email }}
                            </a>
                        </div>
                    </div>
                    @if($inquiry->service)
                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Service Interest</label>
                            <div><span class="badge bg-light-info text-info">{{ $inquiry->service }}</span></div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Received</label>
                        <div>{{ $inquiry->created_at?->format('d M Y, H:i') ?? '—' }}</div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label text-muted mb-1">Status</label>
                        <div>
                            <span class="badge bg-light-success text-success">
                                <i class="ti ti-check me-1"></i>Read
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
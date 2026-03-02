@extends('layouts.backend')

@section('title', 'Dashboard')

@section('content')
    {{-- Welcome Banner --}}
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-primary">Admin Dashboard</h3>
            <p class="text-muted">Veridian Solutions Content Management System.</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row">
        {{-- Total Services --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white dashnum-card overflow-hidden">
                <span class="round small"></span>
                <span class="round big"></span>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="avtar avtar-lg bg-light-primary">
                                <i class="ti ti-briefcase text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <span class="text-white d-block f-34 f-w-500 my-2">{{ $totalServices }}</span>
                    <p class="mb-0 opacity-75">Total Services</p>
                </div>
            </div>
        </div>

        {{-- Active Projects --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary-dark text-white dashnum-card overflow-hidden">
                <span class="round small"></span>
                <span class="round big"></span>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="avtar avtar-lg bg-light-secondary">
                                <i class="ti ti-folder text-secondary"></i>
                            </div>
                        </div>
                    </div>
                    <span class="text-white d-block f-34 f-w-500 my-2">{{ $totalProjects }}</span>
                    <p class="mb-0 opacity-75">Active Projects</p>
                </div>
            </div>
        </div>

        {{-- Unread Inquiries --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white dashnum-card overflow-hidden">
                <span class="round small"></span>
                <span class="round big"></span>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="avtar avtar-lg bg-light-warning">
                                <i class="ti ti-message text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <span class="text-white d-block f-34 f-w-500 my-2">{{ $unreadInquiries }}</span>
                    <p class="mb-0 opacity-75">Unread Inquiries</p>
                </div>
            </div>
        </div>

        {{-- Blog Posts --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white dashnum-card overflow-hidden">
                <span class="round small"></span>
                <span class="round big"></span>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="avtar avtar-lg bg-light-success">
                                <i class="ti ti-news text-success"></i>
                            </div>
                        </div>
                    </div>
                    <span class="text-white d-block f-34 f-w-500 my-2">{{ $totalBlogPosts }}</span>
                    <p class="mb-0 opacity-75">Blog Posts</p>
                </div>
            </div>
        </div>

        {{-- Inquiry Trend Chart --}}
        <div class="col-xl-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Inquiry Trend (Last 7 Months)</h5>
                </div>
                <div class="card-body">
                    <div id="growthchart"></div>
                </div>
            </div>
        </div>

        {{-- Project Categories Pie --}}
        <div class="col-xl-4 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Project Categories</h5>
                </div>
                <div class="card-body">
                    <div id="statuschart" style="min-height: 180px;"></div>
                    @if(count($catLabels) > 0)
                        <div class="text-center mt-3">
                            @foreach($catLabels as $i => $label)
                                <p class="mb-1 text-truncate">
                                    <span class="badge me-2" style="background:{{ $catColors[$i] ?? '#999' }}">●</span>
                                    {{ $label }}: {{ $catData[$i] }} {{ Str::plural('project', $catData[$i]) }}
                                </p>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center mt-3">No project categories yet.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Content Stats (middle cards) --}}
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-lg bg-light-info">
                            <i class="ti ti-message-circle-2 text-info f-24"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0">{{ $totalTestimonials }}</h3>
                            <p class="text-muted mb-0">Testimonials</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-lg bg-light-primary">
                            <i class="ti ti-users text-primary f-24"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0">{{ $totalTeamMembers }}</h3>
                            <p class="text-muted mb-0">Team Members</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-lg bg-light-warning">
                            <i class="ti ti-mail text-warning f-24"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0">{{ $totalInquiries }}</h3>
                            <p class="text-muted mb-0">Total Inquiries</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Inquiries Table --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Recent Inquiries</h5>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Sender</th>
                                    <th>Service Interest</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInquiries as $inquiry)
                                    <tr>
                                        <td>{{ $inquiry->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="m-0">{{ $inquiry->name }}</h6>
                                                    <span class="text-muted f-12">{{ $inquiry->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $inquiry->service ?? '—' }}</td>
                                        <td>
                                            @if($inquiry->is_read)
                                                <span class="badge bg-light-success text-success">Read</span>
                                            @else
                                                <span class="badge bg-light-warning text-warning">Unread</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.inquiries.show', $inquiry->id_inquiry) }}"
                                                class="btn btn-icon btn-light-primary btn-sm" title="View">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No inquiries yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inquiry Trend Area Chart
            var growthOptions = {
                series: [{
                    name: 'Inquiries',
                    data: @json($trendData)
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: { show: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    type: 'category',
                    categories: @json($trendLabels)
                },
                colors: ['#4680ff'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.5,
                        opacityTo: 0.1
                    }
                },
                tooltip: { y: { formatter: function (val) { return val + ' inquiries'; } } }
            };
            new ApexCharts(document.querySelector("#growthchart"), growthOptions).render();

            // Project Categories Pie Chart
            @if(count($catLabels) > 0)
                var pieOptions = {
                    series: @json($catData),
                    chart: {
                        width: '100%',
                        type: 'pie'
                    },
                    labels: @json($catLabels),
                    colors: @json(array_slice($catColors, 0, count($catLabels))),
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: { width: '100%' },
                            legend: { position: 'bottom' }
                        }
                    }]
                };
                new ApexCharts(document.querySelector("#statuschart"), pieOptions).render();
            @endif
                });
    </script>
@endpush
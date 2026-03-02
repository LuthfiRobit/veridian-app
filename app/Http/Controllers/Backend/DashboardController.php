<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Inquiry;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\ProjectCategory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stat Cards (single queries, no N+1) ──
        $totalServices = Service::count();
        $totalProjects = Project::count();
        $unreadInquiries = Inquiry::unread()->count();
        $totalBlogPosts = BlogPost::count();
        $totalTestimonials = Testimonial::count();
        $totalTeamMembers = TeamMember::count();
        $totalInquiries = Inquiry::count();

        // ── Inquiry Trend: last 7 months (single raw query) ──
        $inquiryTrend = Inquiry::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("DATE_FORMAT(created_at, '%b') as label"),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month', 'label')
            ->orderBy('month')
            ->get();

        $trendLabels = $inquiryTrend->pluck('label')->toArray();
        $trendData = $inquiryTrend->pluck('total')->toArray();

        // Fill empty months if less than 7
        if (count($trendLabels) < 7) {
            $trendLabels = [];
            $trendData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $key = $date->format('Y-m');
                $trendLabels[] = $date->format('M');
                $found = $inquiryTrend->firstWhere('month', $key);
                $trendData[] = $found ? $found->total : 0;
            }
        }

        // ── Project Categories Breakdown (single query with join) ──
        $categoryBreakdown = ProjectCategory::withCount('projects')
            ->having('projects_count', '>', 0)
            ->orderByDesc('projects_count')
            ->limit(5)
            ->get();

        $catLabels = $categoryBreakdown->map(fn($c) => $c->getTranslated('name', 'Unknown'))->toArray();
        $catData = $categoryBreakdown->pluck('projects_count')->toArray();
        $catColors = ['#4680ff', '#28a745', '#ffc107', '#dc3545', '#6f42c1'];

        // ── Recent Inquiries (single query, limit 5) ──
        $recentInquiries = Inquiry::unread()->orderByDesc('created_at')->limit(5)->get();

        return view('backend.dashboard', compact(
            'totalServices',
            'totalProjects',
            'unreadInquiries',
            'totalBlogPosts',
            'totalTestimonials',
            'totalTeamMembers',
            'totalInquiries',
            'trendLabels',
            'trendData',
            'catLabels',
            'catData',
            'catColors',
            'recentInquiries'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Staff;
use App\Models\ClassModel;
use App\Models\Payment;
use App\Models\Membership;
use App\Models\Attendance;
use App\Models\PerformanceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard based on user role
     */
    public function index()
    {
        $user = auth()->user();
        $role = $user->role->role_name;

        switch ($role) {
            case 'Admin':
                return $this->adminDashboard();
            case 'Manager':
                return $this->managerDashboard();
            case 'Trainer':
                return $this->trainerDashboard();
            case 'Member':
                return $this->memberDashboard();
            case 'Staff':
                return $this->staffDashboard();
            default:
                return $this->userDashboard();
        }
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        $stats = [
            'totalMembers' => Member::count(),
            'activeMembers' => Member::whereHas('user', function($query) {
                $query->where('status', 'Active');
            })->count(),
            'totalStaff' => Staff::count(),
            'totalClasses' => ClassModel::count(),
            'totalRevenue' => Payment::sum('amount'),
            'thisMonthRevenue' => Payment::whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount'),
        ];

        $recentMembers = Member::with('user')
            ->whereHas('user', function($query) {
                $query->where('registration_date', '>=', now()->subDays(30));
            })
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['member.user'])
            ->latest('payment_date')
            ->take(5)
            ->get();

        return view('dashboards.admin', compact('stats', 'recentMembers', 'recentPayments'));
    }

    /**
     * Manager Dashboard
     */
    private function managerDashboard()
    {
        $stats = [
            'totalMembers' => Member::count(),
            'activeMembers' => Member::whereHas('user', function($query) {
                $query->where('status', 'Active');
            })->count(),
            'totalClasses' => ClassModel::count(),
            'totalRevenue' => Payment::sum('amount'),
        ];

        $upcomingClasses = ClassModel::with('trainer')
            ->where('schedule_time', '>', now())
            ->orderBy('schedule_time')
            ->take(5)
            ->get();

        $membershipStats = Membership::withCount('members')->get();

        return view('dashboards.manager', compact('stats', 'upcomingClasses', 'membershipStats'));
    }

    /**
     * Trainer Dashboard
     */
    private function trainerDashboard()
    {
        $trainerId = auth()->id();
        
        $stats = [
            'totalClasses' => ClassModel::where('trainer_id', $trainerId)->count(),
            'upcomingClasses' => ClassModel::where('trainer_id', $trainerId)
                ->where('schedule_time', '>', now())
                ->count(),
            'totalBookings' => DB::table('class_bookings')
                ->join('classes', 'class_bookings.class_id', '=', 'classes.class_id')
                ->where('classes.trainer_id', $trainerId)
                ->count(),
        ];

        $myClasses = ClassModel::where('trainer_id', $trainerId)
            ->with(['bookings.member.user'])
            ->where('schedule_time', '>', now())
            ->orderBy('schedule_time')
            ->take(5)
            ->get();

        return view('dashboards.trainer', compact('stats', 'myClasses'));
    }

    /**
     * Member Dashboard
     */
    private function memberDashboard()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Member profile not found.');
        }

        $stats = [
            'totalBookings' => $member->bookings()->count(),
            'upcomingBookings' => $member->bookings()
                ->whereHas('class', function($query) {
                    $query->where('schedule_time', '>', now());
                })
                ->count(),
            'totalPayments' => $member->payments()->count(),
            'lastCheckIn' => $member->attendance()
                ->latest('check_in')
                ->first(),
        ];

        $myBookings = $member->bookings()
            ->with(['class.trainer'])
            ->whereHas('class', function($query) {
                $query->where('schedule_time', '>', now());
            })
            ->orderBy('booking_date')
            ->take(5)
            ->get();

        $myPayments = $member->payments()
            ->latest('payment_date')
            ->take(5)
            ->get();

        return view('dashboards.member', compact('stats', 'myBookings', 'myPayments'));
    }

    /**
     * Staff Dashboard
     */
    private function staffDashboard()
    {
        $stats = [
            'totalMembers' => Member::count(),
            'activeMembers' => Member::whereHas('user', function($query) {
                $query->where('status', 'Active');
            })->count(),
            'totalClasses' => ClassModel::count(),
            'todayCheckIns' => Attendance::whereDate('check_in', today())->count(),
        ];

        $todayClasses = ClassModel::with('trainer')
            ->whereDate('schedule_time', today())
            ->orderBy('schedule_time')
            ->get();

        $recentCheckIns = Attendance::with(['member.user'])
            ->latest('check_in')
            ->take(5)
            ->get();

        return view('dashboards.staff', compact('stats', 'todayClasses', 'recentCheckIns'));
    }

    /**
     * User Dashboard (default)
     */
    private function userDashboard()
    {
        return view('dashboards.user');
    }

    /**
     * Get performance reports
     */
    public function performanceReports()
    {
        $reports = PerformanceReport::orderBy('report_date', 'desc')->get();
        return view('dashboard.performance-reports', compact('reports'));
    }

    /**
     * Get attendance statistics
     */
    public function attendanceStats()
    {
        $stats = [
            'todayCheckIns' => Attendance::whereDate('check_in', today())->count(),
            'thisWeekCheckIns' => Attendance::whereBetween('check_in', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'thisMonthCheckIns' => Attendance::whereMonth('check_in', now()->month)
                ->whereYear('check_in', now()->year)
                ->count(),
        ];

        return view('dashboard.attendance-stats', compact('stats'));
    }
}

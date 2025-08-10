<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $role = $user->role->role_name ?? 'user';

        switch ($role) {
            case 'admin':
                return $this->adminDashboard();
            case 'manager':
                return $this->managerDashboard();
            case 'trainer':
                return $this->trainerDashboard();
            case 'staff':
                return $this->staffDashboard();
            case 'member':
                return $this->memberDashboard();
            default:
                return $this->userDashboard();
        }
    }

    public function adminDashboard(): View
    {
        $stats = [
            'total_members' => \App\Models\Member::count(),
            'total_staff' => \App\Models\Staff::count(),
            'total_classes' => \App\Models\ClassModel::count(),
            'total_payments' => \App\Models\Payment::sum('amount'),
        ];
        
        return view('dashboards.admin', compact('stats'));
    }

    public function managerDashboard(): View
    {
        $stats = [
            'total_members' => \App\Models\Member::count(),
            'active_memberships' => \App\Models\Membership::where('status', 'active')->count(),
            'monthly_revenue' => \App\Models\Payment::whereMonth('created_at', now()->month)->sum('amount'),
            'upcoming_classes' => \App\Models\ClassModel::where('date', '>=', now())->count(),
        ];
        
        return view('dashboards.manager', compact('stats'));
    }

    public function trainerDashboard(): View
    {
        $trainer = auth()->user()->staff;
        $stats = [
            'my_classes' => \App\Models\ClassModel::where('trainer_id', $trainer->staff_id ?? 0)->count(),
            'upcoming_sessions' => \App\Models\TrainingSession::where('trainer_id', $trainer->staff_id ?? 0)
                ->where('date', '>=', now())->count(),
            'total_members_trained' => \App\Models\ClassBooking::whereHas('class', function($q) use ($trainer) {
                $q->where('trainer_id', $trainer->staff_id ?? 0);
            })->distinct('member_id')->count(),
        ];
        
        return view('dashboards.trainer', compact('stats'));
    }

    public function staffDashboard(): View
    {
        $stats = [
            'check_ins_today' => \App\Models\Attendance::whereDate('created_at', today())->count(),
            'equipment_available' => \App\Models\Equipment::where('status', 'available')->count(),
            'pending_notifications' => \App\Models\Notification::where('status', 'pending')->count(),
        ];
        
        return view('dashboards.staff', compact('stats'));
    }

    public function memberDashboard(): View
    {
        $member = auth()->user()->member;
        $stats = [
            'membership_status' => $member->membership->status ?? 'inactive',
            'classes_booked' => \App\Models\ClassBooking::where('member_id', $member->member_id ?? 0)->count(),
            'attendance_rate' => \App\Models\Attendance::where('member_id', $member->member_id ?? 0)->count(),
            'next_class' => \App\Models\ClassBooking::where('member_id', $member->member_id ?? 0)
                ->whereHas('class', function($q) {
                    $q->where('date', '>=', now());
                })->first(),
        ];
        
        return view('dashboards.member', compact('stats'));
    }

    public function userDashboard(): View
    {
        return view('dashboards.user');
    }
}

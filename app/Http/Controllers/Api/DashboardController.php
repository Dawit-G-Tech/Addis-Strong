<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Staff;
use App\Models\ClassModel;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $stats = [
            'totalMembers' => Member::count(),
            'activeMembers' => Member::whereHas('user', function($query) {
                $query->where('status', 'Active');
            })->count(),
            'totalStaff' => Staff::count(),
            'totalClasses' => ClassModel::count(),
            'totalRevenue' => Payment::sum('amount'),
        ];

        return response()->json($stats);
    }
}

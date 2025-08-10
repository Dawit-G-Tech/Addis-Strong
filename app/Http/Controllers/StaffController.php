<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::with(['user', 'schedules'])->get();
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Rather Not Say',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();
        try {
            // Create user first
            $user = User::create([
                'email' => $request->email,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'password' => Hash::make($request->password),
                'role_id' => 1, // Assuming 1 is Staff role
                'status' => 'Active',
            ]);

            // Create staff
            $staff = Staff::create([
                'phone' => $request->phone,
                'address' => $request->address,
                'staff_id' => $user->user_id,
                'hire_date' => $request->hire_date,
                'salary' => $request->salary,
            ]);

            DB::commit();
            return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating staff: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        $staff->load(['user', 'schedules']);
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        $staff->load('user');
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $staff->staff_id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Rather Not Say',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Inactive,Banned',
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $staff->user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'address' => $request->address,
                'status' => $request->status,
            ]);

            // Update staff
            $staff->update([
                'hire_date' => $request->hire_date,
                'salary' => $request->salary,
            ]);

            DB::commit();
            return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating staff: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        try {
            $staff->user->delete(); // This will cascade delete the staff
            return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting staff: ' . $e->getMessage());
        }
    }

    /**
     * Get staff statistics
     */
    public function statistics()
    {
        $totalStaff = Staff::count();
        $activeStaff = Staff::whereHas('user', function($query) {
            $query->where('status', 'Active');
        })->count();
        $totalSalary = Staff::sum('salary');

        return view('staff.statistics', compact('totalStaff', 'activeStaff', 'totalSalary'));
    }
}

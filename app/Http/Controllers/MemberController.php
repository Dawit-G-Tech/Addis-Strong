<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with(['user', 'membership'])->get();
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $memberships = Membership::where('status', 'active')->get();
        return view('members.create', compact('memberships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Rather Not Say',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'height' => 'nullable|numeric|min:0|max:999.99',
            'membership_id' => 'nullable|exists:memberships,membership_id',
            'password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();
        try {
            // Create user first
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'address' => $request->address,
                'hashed_password' => Hash::make($request->password),
                'role_id' => 3, // Assuming 3 is Member role
                'status' => 'Active',
            ]);

            // Create member
            $member = Member::create([
                'member_id' => $user->user_id,
                'membership_id' => $request->membership_id,
                'weight' => $request->weight,
                'height' => $request->height,
            ]);

            DB::commit();
            return redirect()->route('members.index')->with('success', 'Member created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating member: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load(['user', 'membership', 'payments', 'bookings', 'trainingSessions', 'attendance']);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $memberships = Membership::where('status', 'active')->get();
        $member->load('user');
        return view('members.edit', compact('member', 'memberships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $member->member_id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Rather Not Say',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'height' => 'nullable|numeric|min:0|max:999.99',
            'membership_id' => 'nullable|exists:memberships,membership_id',
            'status' => 'required|in:Active,Inactive,Banned',
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $member->user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'address' => $request->address,
                'status' => $request->status,
            ]);

            // Update member
            $member->update([
                'membership_id' => $request->membership_id,
                'weight' => $request->weight,
                'height' => $request->height,
            ]);

            DB::commit();
            return redirect()->route('members.index')->with('success', 'Member updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating member: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        try {
            $member->user->delete(); // This will cascade delete the member
            return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting member: ' . $e->getMessage());
        }
    }

    /**
     * Get member statistics
     */
    public function statistics()
    {
        $totalMembers = Member::count();
        $activeMembers = Member::whereHas('user', function($query) {
            $query->where('status', 'Active');
        })->count();
        $newMembersThisMonth = Member::whereHas('user', function($query) {
            $query->where('registration_date', '>=', now()->startOfMonth());
        })->count();

        return view('members.statistics', compact('totalMembers', 'activeMembers', 'newMembersThisMonth'));
    }
}

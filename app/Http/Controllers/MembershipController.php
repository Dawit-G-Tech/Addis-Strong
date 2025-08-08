<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = Membership::with('members')->get();
        return view('memberships.index', compact('memberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('memberships.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'duration_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'access_level' => 'required|in:Basic,Standard,Premium',
            'status' => 'required|in:active,expired,renewal',
        ]);

        try {
            Membership::create([
                'name' => $request->name,
                'duration_months' => $request->duration_months,
                'price' => $request->price,
                'access_level' => $request->access_level,
                'status' => $request->status,
            ]);

            return redirect()->route('memberships.index')->with('success', 'Membership created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating membership: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        $membership->load('members.user');
        return view('memberships.show', compact('membership'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        return view('memberships.edit', compact('membership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'duration_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'access_level' => 'required|in:Basic,Standard,Premium',
            'status' => 'required|in:active,expired,renewal',
        ]);

        try {
            $membership->update([
                'name' => $request->name,
                'duration_months' => $request->duration_months,
                'price' => $request->price,
                'access_level' => $request->access_level,
                'status' => $request->status,
            ]);

            return redirect()->route('memberships.index')->with('success', 'Membership updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating membership: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        try {
            $membership->delete();
            return redirect()->route('memberships.index')->with('success', 'Membership deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting membership: ' . $e->getMessage());
        }
    }

    /**
     * Get membership statistics
     */
    public function statistics()
    {
        $totalMemberships = Membership::count();
        $activeMemberships = Membership::where('status', 'active')->count();
        $totalMembers = Membership::withCount('members')->get()->sum('members_count');

        return view('memberships.statistics', compact('totalMemberships', 'activeMemberships', 'totalMembers'));
    }
}

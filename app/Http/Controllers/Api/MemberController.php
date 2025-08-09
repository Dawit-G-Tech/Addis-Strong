<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'membership'])->get();
        return response()->json($members);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'membership_id' => 'nullable|exists:memberships,membership_id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
        ]);

        $member = Member::create($validated);
        return response()->json($member->load(['user', 'membership']), 201);
    }

    public function show(Member $member)
    {
        return response()->json($member->load(['user', 'membership']));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'membership_id' => 'nullable|exists:memberships,membership_id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
        ]);

        $member->update($validated);
        return response()->json($member->load(['user', 'membership']));
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json(null, 204);
    }
}

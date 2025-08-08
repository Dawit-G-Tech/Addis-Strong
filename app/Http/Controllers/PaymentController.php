<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['member.user'])->get();
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::with('user')->get();
        return view('payments.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:Cash,Card,Mobile,Bank Transfer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            Payment::create([
                'member_id' => $request->member_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => now(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating payment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['member.user']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $members = Member::with('user')->get();
        return view('payments.edit', compact('payment', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:Cash,Card,Mobile,Bank Transfer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $payment->update([
                'member_id' => $request->member_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating payment: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting payment: ' . $e->getMessage());
        }
    }

    /**
     * Get payment statistics
     */
    public function statistics()
    {
        $totalPayments = Payment::count();
        $totalRevenue = Payment::sum('amount');
        $thisMonthRevenue = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        return view('payments.statistics', compact('totalPayments', 'totalRevenue', 'thisMonthRevenue'));
    }

    /**
     * Get payments by member
     */
    public function byMember($memberId)
    {
        $payments = Payment::where('member_id', $memberId)
            ->with(['member.user'])
            ->get();
        
        return view('payments.by-member', compact('payments'));
    }
}

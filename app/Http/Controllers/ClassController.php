<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassModel::with(['trainer'])->get();
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainers = User::where('role_id', 2)->get(); // Assuming 2 is Trainer role
        return view('classes.create', compact('trainers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'trainer_id' => 'required|exists:users,user_id',
            'schedule_time' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
        ]);

        try {
            ClassModel::create([
                'name' => $request->name,
                'description' => $request->description,
                'trainer_id' => $request->trainer_id,
                'schedule_time' => $request->schedule_time,
                'duration_minutes' => $request->duration_minutes,
                'capacity' => $request->capacity,
            ]);

            return redirect()->route('classes.index')->with('success', 'Class created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating class: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassModel $class)
    {
        $class->load(['trainer', 'bookings.member.user']);
        return view('classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassModel $class)
    {
        $trainers = User::where('role_id', 2)->get(); // Assuming 2 is Trainer role
        return view('classes.edit', compact('class', 'trainers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'trainer_id' => 'required|exists:users,user_id',
            'schedule_time' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
        ]);

        try {
            $class->update([
                'name' => $request->name,
                'description' => $request->description,
                'trainer_id' => $request->trainer_id,
                'schedule_time' => $request->schedule_time,
                'duration_minutes' => $request->duration_minutes,
                'capacity' => $request->capacity,
            ]);

            return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating class: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassModel $class)
    {
        try {
            $class->delete();
            return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting class: ' . $e->getMessage());
        }
    }

    /**
     * Get class statistics
     */
    public function statistics()
    {
        $totalClasses = ClassModel::count();
        $upcomingClasses = ClassModel::where('schedule_time', '>', now())->count();
        $totalBookings = DB::table('class_bookings')->count();

        return view('classes.statistics', compact('totalClasses', 'upcomingClasses', 'totalBookings'));
    }

    /**
     * Get classes by trainer
     */
    public function byTrainer($trainerId)
    {
        $classes = ClassModel::where('trainer_id', $trainerId)
            ->with(['trainer', 'bookings'])
            ->get();
        
        return view('classes.by-trainer', compact('classes'));
    }
}

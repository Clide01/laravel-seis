<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // MUST ADD THIS for random strings

class StudentController extends Controller
{
    public function showApplicationForm() {
        return view('auth.apply'); 
    }

    // 1. GENERATE THE CODE WHEN THEY APPLY
    public function submitApplication(Request $request) {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:applications',
            'gender' => 'required',
            'birthdate' => 'required|date',
            'preferred_course' => 'required'
        ]);

        $data = $request->all();
        // Generate a random 8-character tracking code (e.g., TRK-A8F9K2)
        $data['tracking_code'] = 'TRK-' . strtoupper(Str::random(6)); 
        
        Application::create($data);

        // Send the generated tracking code back to the view
        return back()->with('success', 'Application submitted successfully!')
                     ->with('tracking_code', $data['tracking_code']);
    }

    // 2. CHECK THE STATUS
    public function checkStatus(Request $request) {
        $request->validate(['tracking_code' => 'required|string']);

        $application = Application::where('tracking_code', $request->tracking_code)->first();

        if (!$application) {
            return back()->with('tracker_error', 'Invalid Tracking Code. Please try again.');
        }

        return back()->with('tracker_result', $application);
    }

public function dashboard() {
        // 1. Get the currently logged-in student
        $user = Auth::user();

        // 2. Check if they have been enrolled in a section
        $enrollment = \App\Models\Enrollment::with('section')
                        ->where('user_id', $user->id)
                        ->first();
        
        // 3. If they have a section, fetch that section's schedule
        $schedules = [];
        if ($enrollment) {
            $schedules = \Illuminate\Support\Facades\DB::table('schedules')
                            ->where('section_id', $enrollment->section_id)
                            ->orderBy('start_time')
                            ->get();
        }

        // 4. Send all this data to the view
        return view('student.dashboard', compact('user', 'enrollment', 'schedules'));
    }
}
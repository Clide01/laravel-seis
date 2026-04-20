<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;
use App\Models\Enrollment;

class SectionController extends Controller
{
    // 1. View all sections & staff members
    public function index() {
        $sections = Section::all();
        $staffMembers = User::where('role', 'staff')->get();
        return view('admin.sections.index', compact('sections', 'staffMembers'));
    }

    // 2. Save a new section
    public function store(Request $request) {
        $request->validate([
            'section_name' => 'required|string|max:50',
            'max_capacity' => 'required|integer',
            'adviser_id' => 'nullable|exists:users,id'
        ]);

        Section::create($request->all());
        return back()->with('success', 'Section created successfully!');
    }

    // 3. View the Section Manager (Enrollments & Schedules)
// 3. View the Section Manager (Enrollments & Schedules)
    public function show($id) {
        $section = Section::findOrFail($id);
        
        // 1. Get emails of approved applicants for this course
        $courseEmails = \App\Models\Application::where('status', 'approved')
                            ->where('preferred_course', $section->course)
                            ->pluck('email');

        // 2. Find students not yet enrolled who match this course
        $enrolledIds = Enrollment::pluck('user_id');
        $available_students = User::where('role', 'student')
                                ->whereIn('email', $courseEmails)
                                ->whereNotIn('id', $enrolledIds)
                                ->get();
        
        // 3. Get currently enrolled students
        $enrolled_students = Enrollment::with('student')->where('section_id', $id)->get();
        
        // 4. ADD THIS: Fetch all subjects for the dropdown
        $subjects = \Illuminate\Support\Facades\DB::table('subjects')->get();
        
        // 5. Fetch schedules joined with subject names
        $schedules = \Illuminate\Support\Facades\DB::table('schedules')
                        ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
                        ->where('section_id', $id)
                        ->select('schedules.*', 'subjects.name as subject_name', 'subjects.subject_code')
                        ->get();

        $teachers = User::where('role', 'staff')->get();
            return view('admin.sections.show', compact('section', 'available_students', 'enrolled_students', 'schedules', 'subjects', 'teachers'));

        // 6. Pass ALL variables to the view
        return view('admin.sections.show', compact(
            'section', 
            'available_students', 
            'enrolled_students', 
            'schedules', 
            'subjects' // This is the missing piece!
        ));
    }

    // 4. BATCH Enroll Students (Checkbox Logic)
    public function enrollStudent(Request $request, $id) {
        // Validate that an array of checkboxes was submitted
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id' // Check that every ID is a real user
        ], [
            'user_ids.required' => 'You must select at least one student to enroll.'
        ]);
        
        // Loop through every checked box and enroll them
        foreach ($request->user_ids as $userId) {
            Enrollment::create([
                'section_id' => $id,
                'user_id' => $userId,
                'school_year' => '2026-2027'
            ]);
        }
        
        // Count how many were added for a nice success message
        $count = count($request->user_ids);
        return back()->with('success', "{$count} student(s) successfully enrolled in the section!");
    }

    // 5. Add a Schedule
    public function addSchedule(Request $request, $id) {
        // 1. Validate to ensure a subject and teacher were actually picked
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day'        => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'room'       => 'required',
        ]);

        // 2. Insert the specific data from the form
        DB::table('schedules')->insert([
            'section_id' => $id,
            'subject_id' => $request->subject_id, // This uses your dropdown selection
            'teacher_id' => $request->teacher_id, // This uses your teacher selection
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'room'       => $request->room,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Class schedule added successfully!');
    }

    // 6. Remove a student from a section
    public function unenrollStudent($section_id, $user_id) {
        \App\Models\Enrollment::where('section_id', $section_id)
                              ->where('user_id', $user_id)
                              ->delete();
                              
        return back()->with('success', 'Student successfully removed from this section.');
    }

    // 7. Delete an entire section
    public function destroy($id) {
        $section = Section::findOrFail($id);
        
        // This will automatically delete connected enrollments and schedules 
        // because we used onDelete('cascade') in the database migrations!
        $section->delete();
        
        return redirect()->route('sections.index')->with('success', 'Section and all its data deleted successfully.');
    }
    // Show Edit Schedule Page
    public function editSchedule($id) {
        $schedule = DB::table('schedules')->where('id', $id)->first();
        $subjects = DB::table('subjects')->get();
        return view('admin.sections.edit_schedule', compact('schedule', 'subjects'));
    }

    // Process Schedule Update
    public function updateSchedule(Request $request, $id) {
        DB::table('schedules')->where('id', $id)->update([
            'subject_id' => $request->subject_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'room' => $request->room,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Schedule updated successfully!');
    }

    // Delete Schedule
    public function destroySchedule($id) 
    {
        \Illuminate\Support\Facades\DB::table('schedules')->where('id', $id)->delete();
        return back()->with('success', 'Schedule deleted successfully!');
    }
}
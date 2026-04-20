<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index()
    {
        $teacher_id = Auth::id();

        // 1. Get all schedules assigned to this teacher across ANY section
        $my_schedules = DB::table('schedules')
                        ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
                        ->join('sections', 'schedules.section_id', '=', 'sections.id') 
                        ->where('schedules.teacher_id', $teacher_id)
                        ->select('schedules.*', 'subjects.name as subject_name', 'subjects.subject_code', 'sections.section_name')
                        ->get();

        // 2. Get the unique IDs of all sections this teacher teaches in
        $sectionIds = $my_schedules->pluck('section_id')->unique();

        // 3. Fetch students from all those sections
        // We use with('student') to get user details and with('section') for context
        $my_students = \App\Models\Enrollment::with(['student', 'section'])
                        ->whereIn('section_id', $sectionIds)
                        ->get();

        // 4. We pass a boolean 'has_classes' instead of 'my_section' to handle the UI
        $has_classes = $my_schedules->isNotEmpty();

        return view('staff.dashboard', compact('my_schedules', 'my_students', 'has_classes'));
    }
}
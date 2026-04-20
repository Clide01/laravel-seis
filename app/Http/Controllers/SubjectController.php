<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = DB::table('subjects')->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_code' => 'required|unique:subjects',
            'name' => 'required',
            'units' => 'required|integer'
        ]);

        DB::table('subjects')->insert([
            'subject_code' => $request->subject_code,
            'name' => $request->name,
            'units' => $request->units,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Subject added successfully!');
    }
    // Show edit form
    public function edit($id) {
        $subject = DB::table('subjects')->where('id', $id)->first();
        
        // Make sure this matches your folder structure: resources/views/admin/subjects/edit.blade.php
        return view('admin.subjects.edit', compact('subject'));
    }

    // Process update
    public function update(Request $request, $id) {
        $request->validate([
            'subject_code' => 'required|unique:subjects,subject_code,'.$id,
            'name' => 'required',
            'units' => 'required|integer'
        ]);

        DB::table('subjects')->where('id', $id)->update([
            'subject_code' => $request->subject_code,
            'name' => $request->name,
            'units' => $request->units,
            'updated_at' => now(),
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject updated!');
    }

    // Delete subject
    public function destroy($id) {
        DB::table('subjects')->where('id', $id)->delete();
        return back()->with('success', 'Subject removed from registry.');
    }
}
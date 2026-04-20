<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function approve($id) {
    $app = Application::findOrFail($id);
    
    // 1. Create User Account
    $user = User::create([
        'name' => $app->first_name . ' ' . $app->last_name,
        'email' => $app->email,
        'password' => Hash::make('Student123!'), // Default password
        'role' => 'student'
    ]);

    // 2. Update Application Status
    $app->update(['status' => 'approved']);

    return back()->with('success', 'Student approved and account created.');
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;           // Important: Import User Model
use App\Models\Application;    // Important: Import Application Model
use App\Models\Section;        // Important: Import Section Model
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with Statistics
     */
public function index() {
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_staff'    => User::where('role', 'staff')->count(),
            'pending_apps'   => Application::where('status', 'pending')->count(),
            'sections'       => \App\Models\Section::count(),
        ];
        
        // FIX: Only fetch applications that are actually 'pending'
        $recent_applications = Application::where('status', 'pending')
                                          ->latest()
                                          ->take(5)
                                          ->get();
        
        return view('admin.dashboard', compact('stats', 'recent_applications'));
    }

    /**
     * List all users (Admin/Staff/Students)
     */
    public function userIndex() {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        return view('admin.users.create');
    }
    /**
     * Store a newly created user (Staff or Student)
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,staff,student',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'User created successfully!');
    }

    /**
     * Remove a user from the system
     */
    public function destroy($id) {
        $user = User::findOrFail($id);
        
        // Prevent admin from deleting themselves
        if(auth()->id() == $user->id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
    /**
     * Approve an admission application and create a Student account
     */
public function approveApplication(Request $request, $id) {
        $application = Application::findOrFail($id);
        
        $request->validate(['password' => 'required|min:6']);

        if (\App\Models\User::where('email', $application->email)->exists()) {
            return back()->with('error', 'Approval failed: User already exists.');
        }

        // Create the Student Account
        $user = \App\Models\User::create([
            'name' => $application->first_name . ' ' . $application->last_name,
            'email' => $application->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'student',
        ]);

        // UPDATE THIS LINE: Mark as approved AND save the plain text password for the tracker
        $application->update([
            'status' => 'approved',
            'assigned_password' => $request->password
        ]);

        return redirect()->route('admin.dashboard')->with('success', 
            "Application Approved! The student can now use their tracking code to view their credentials."
        );
    }

    // --- USER MANAGEMENT UPDATES ---
    
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id, // Ignore current user's email
            'role' => 'required|in:admin,staff,student',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        // Only update password if admin typed a new one
        if($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        
        $user->save();
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // --- ADMISSION UPDATES ---

    public function showApplication($id) {
        $application = Application::findOrFail($id);
        return view('admin.applications.show', compact('application'));
    }
}
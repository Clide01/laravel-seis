<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $role = Auth::user()->role;

        return match($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'staff'   => redirect()->route('staff.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default   => abort(403),
        };
    }
}
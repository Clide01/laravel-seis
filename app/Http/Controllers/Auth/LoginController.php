<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // 1. Ensure this is here
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller // 2. Ensure it extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected $redirectTo = '/home'; // This points to the Traffic Cop we made earlier

    public function __construct()
    {
        // This is the line causing the error if "extends Controller" is missing
        $this->middleware('guest')->except('logout');
    }
}
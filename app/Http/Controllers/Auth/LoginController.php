<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\BusCompany; // Import your BusCompany model

class LoginController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Login Controller
    |----------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the redirectTo() method to handle custom redirections based on user role.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if (Auth::check()) {
            $user = Auth::user();

            switch ($user->role) {
                case '0': // Admin
                    return '/admin/dashboard';
                
                case '1': // Company
                    // Check the status in the bus_companies table
                    $busCompany = BusCompany::where('user_id', $user->id)->first();
                    
                    if ($busCompany && $busCompany->status == 1) {
                        return '/company'; // Redirect to /company if status is 1
                    } else {
                        return '/'; // Redirect to home if status is not 1
                    }

                case '2': // Other role
                    return '/';

                default:
                    return '/'; // Default redirection
            }
        }

        return '/'; // Default if the user is not authenticated
    }
}

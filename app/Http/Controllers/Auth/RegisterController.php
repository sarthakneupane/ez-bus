<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BusCompany;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:1,2'],
            'terms' => 'accepted',
        ];

        if (isset($data['role']) && $data['role'] == '1') {
            $rules['bc_name'] = ['required', 'string', 'max:255','unique:bus_companies'];
            $rules['no_of_buses'] = ['nullable', 'integer', 'min:0'];
            $rules['company_registration'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $rules['cover_letter'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        }

        return Validator::make($data, $rules);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        if ($data['role'] == '1') {
            $company_registration_path = request()->file('company_registration')->store('company_docs', 'public');
            $cover_letter_path = request()->file('cover_letter')->store('company_docs', 'public');

            BusCompany::create([
                'user_id' => $user->id,
                'bc_name' => $data['bc_name'],
                'no_of_bus' => $data['no_of_buses'] ?? 0,
                'status' => '0',
                'company_registration' => $company_registration_path,
                'cover_letter' => $cover_letter_path,
            ]);
        }

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        event(new Registered($user)); // Triggers verification email

        return redirect()->route('verification.notice')->with('status', 'Please check your email to verify your account.');
    }
}

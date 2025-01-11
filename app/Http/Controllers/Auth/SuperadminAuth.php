<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class SuperadminAuth extends Controller
{
    public function view()
    {
        $superAdminExists = Role::where('name', 'superadmin')->whereHas('users')->exists();
        if ($superAdminExists) {
            return redirect()->route('admin.login');
        }

        return view('evotar.superadmin.register');
    }

    public function register(Request $request)
    {
        // Validate input
        $validator = $this->validateInput($request);

        // Create user
        $user = $this->createUser($validator);

        // Redirect with success message
        return redirect()->route('admin.login')->with('success', 'Superadmin registered successfully.');
    }

    public function validateInput(Request $request)
    {
        return Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'required|string|max:3',
            'last_name' => 'required|string|max:255',
            'extension' => 'max:5',
            'gender' => 'required',
            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(18)->toDateString(),
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone_number' => 'required|string|max:25',
            'year_level' => 'required|string|max:25',
            'student_id' => 'required|string|max:255|regex:/^\d{4}-\d{5}$/',
            'campus' => 'required|integer|exists:campuses,id',
            'college' => 'required|integer|exists:colleges,id',
            'program' => 'required|integer|exists:programs,id',
            'program_major' => 'required|integer|exists:program_majors,id',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:password',
        ],
            [
                'first_name.required' => 'First name is required.',
                'middle_initial.required' => 'M.I is required.',
                'last_name.required' => 'Last name is required.',
                'gender.required' => 'Gender is required.',
                'birth_date.required' => 'Birth date is required.',
                'birth_date.before_or_equal' => 'You must be at least 18 years old.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.unique' => 'This email is already registered.',
                'phone_number.required' => 'Phone number is required.',
                'year_level.required' => 'Year level is required.',
                'student_id.required' => 'Student ID is required.',
                'student_id.regex' => 'Student ID must be in the format YYYY-XXXXX.',
                'campus.required' => 'Campus selection is required.',
                'campus.exists' => 'The selected campus does not exist.',
                'college.required' => 'College selection is required.',
                'college.exists' => 'The selected college does not exist.',
                'program.required' => 'Program selection is required.',
                'program.exists' => 'The selected program does not exist.',
                'program_major.required' => 'Program major selection is required.',
                'program_major.exists' => 'The selected program major does not exist.',
                'username.required' => 'Username is required.',
                'username.unique' => 'This username is already taken.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters long.',
                'confirm_password.required' => 'Please confirm your password.',
                'confirm_password.same' => 'Passwords do not match.',
            ])->validate();
    }

    public function createUser(array $validator)
    {
        // Create the user
        $user = User::create([
            'first_name' => $validator['first_name'],
            'middle_initial' => $validator['middle_initial'],
            'last_name' => $validator['last_name'],
            'extension' => $validator['extension'],
            'gender' => $validator['gender'],
            'birth_date' => $validator['birth_date'],
            'email' => $validator['email'],
            'phone_number' => $validator['phone_number'],
            'year_level' => $validator['year_level'],
            'student_id' => $validator['student_id'],
            'campus_id' => $validator['campus'],
            'college_id' => $validator['college'],
            'program_id' => $validator['program'],
            'program_major_id' => $validator['program_major'],
            'username' => $validator['username'],
            'password' => bcrypt($validator['password']),
        ]);

        // Assign the role (make sure the role exists)
        if ($user->assignRole('superadmin')) {
            Log::info('Role assigned successfully');
        } else {
            Log::info('Role assignment failed');
        }

        // Return the created user
        return $user;
    }

    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('admin.super-admin.dashboard');
        }
        return view('evotar.common-admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.super-admin.dashboard');
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        return view('evotar.superadmin.dashboard');
    }

    public function elections()
    {
        return view('evotar.superadmin.election');
    }

    public function candidates()
    {
        return view('evotar.superadmin.candidate');
    }
}

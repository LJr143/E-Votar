<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ViewController extends Controller
{
    /**
     * Show the registration view for superadmin if not already registered.
     */
    public function view()
    {
        if ($this->superAdminExists()) {
            return redirect()->route('admin.login');
        }

        return view('evotar.admin.register');
    }

    /**
     * Handle superadmin registration.
     */
    public function register(Request $request)
    {
        $this->validateInput($request);
        $user = $this->createUser($request->all());

        return redirect()->route('admin.login')->with('success', 'Superadmin registered successfully.');
    }

    /**
     * Check if a superadmin already exists.
     */
    protected function superAdminExists(): bool
    {
        return Role::where('name', 'superadmin')->whereHas('users')->exists();
    }

    /**
     * Validate the user input.
     */
    protected function validateInput(Request $request)
    {
        return Validator::make($request->all(), $this->validationRules(), $this->validationMessages())->validate();
    }

    /**
     * Get the validation rules for registration.
     */
    protected function validationRules(): array
    {
        return [
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
        ];
    }

    /**
     * Get the custom error messages for validation.
     */
    protected function validationMessages(): array
    {
        return [
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
        ];
    }

    /**
     * Create a new user.
     */
    protected function createUser(array $data): User
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_initial' => $data['middle_initial'],
            'last_name' => $data['last_name'],
            'extension' => $data['extension'],
            'gender' => $data['gender'],
            'birth_date' => $data['birth_date'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'year_level' => $data['year_level'],
            'student_id' => $data['student_id'],
            'campus_id' => $data['campus'],
            'college_id' => $data['college'],
            'program_id' => $data['program'],
            'program_major_id' => $data['program_major'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);

        if (!$this->superAdminExists()){
            $this->assignRole($user, 'superadmin');
        }

        return $user;
    }

    /**
     * Assign a role to the user.
     */
    protected function assignRole(User $user, string $role): void
    {
        if ($user->assignRole($role)) {
            Log::info("Role '{$role}' assigned successfully.");
        } else {
            Log::info("Role '{$role}' assignment failed.");
        }
    }

    /**
     * Dashboard view.
     */
    public function adminDashboard()
    {
        $candidates = app(DashboardController::class)->getCandidates();
        return view('evotar.admin.dashboard',compact('candidates'));
    }

    public function technicalOfficerDashboard()
    {
        $candidates = app(DashboardController::class)->getCandidates();
        return view('evotar.technical-officer.dashboard',compact('candidates'));

    }


    /**
     * Election management view.
     */
    public function elections()
    {
        return view('evotar.admin.election');
    }

    /**
     * Candidate management view.
     */
    public function candidates()
    {
        return view('evotar.admin.candidate');
    }

    /**
     * Candidate management view.
     */
    public function positions()
    {
        return view('evotar.admin.position');
    }


    /**
     * Vote tally view.
     */
    public function voteTally()
    {
        return view('evotar.admin.vote_tally');
    }

    /**
     * Election result view.
     */
    public function electionResult()
    {
        return view('evotar.admin.election_result');
    }

    /**
     * Party list view.
     */
    public function partyList()
    {
        return view('evotar.admin.party_list');
    }

    /**
     * Voter management view.
     */
    public function voter()
    {
        return view('evotar.admin.voter');
    }

    public function voterRegistration()
    {
        return view('evotar.admin.voter_registration');
    }


    /**
     * System users management view.
     */
    public function systemUsers()
    {
        return view('evotar.admin.user');
    }

    /**
     * System logs view.
     */
    public function systemLogs()
    {
        return view('evotar.admin.system_logs');
    }

    public function activeUsers()
    {
        return view('evotar.technical-officer.active-user');
    }

    public function ipRecords()
    {
        return view('evotar.technical-officer.ip-record');
    }


    public function voterElectionRedirect()
    {
        return view('evotar.voter.pages.voter-election-redirect');
    }

    public function feedback()
    {
        return view('evotar.admin.feedback');
    }

    public function college()
    {
        return view('evotar.admin.college');

    }

    public function program()
    {
        return view('evotar.admin.program');
    }

    public function programMajor()
    {
        return view('evotar.admin.program_major');
    }


    public function AccountSettings()
    {
        return view('evotar.admin.account-settings');
    }

    public function step1Tutorial()
    {
        return view('evotar.voter.pages.step-1_tutorial');
    }

    public function step2Tutorial()
    {
        return view('evotar.voter.pages.step-2_tutorial');
    }
    public function voterAccountSettings(){
        return view('evotar.voter.pages.accounts-settings');}
    /**
     * Unregistered admins view.
     */
    public function unregisteredAdmins()
    {
        return view('evotar.admin.unregistered_admin');
    }

    /**
     * Register an admin user.
     *
     * @throws Exception
     */
    public function registerAdmins(Request $request)
    {
        $this->validateInput($request);
        $this->createUserAdmin($request->all());

        session()->flash('registered', true);
        return redirect()->route('admin.unregistered.admin');
    }

    /**
     * Create a user as an admin and assign role and
     * give permissions based on role
     *
     * @throws Exception
     */
    public function createUserAdmin(array $data)
    {
        $this->checkForExistingUser($data);

        $user = $this->createUser($data);

        $roleId = $data['role'];

        $role = Role::find($roleId);

        if (!$role) {
            throw new \Exception("Role not found.");
        }

        $this->assignRole($user, $role->name);

        $permissions = $role->permissions;

        $user->syncPermissions($permissions);

        return $user;
    }

    /**
     * Check for existing users before creating a new one.
     *
     * @throws Exception
     */
    protected function checkForExistingUser(array $data)
    {
        $existingUser = User::where('email', $data['email'])
            ->orWhere('username', $data['username'])
            ->orWhere('student_id', $data['student_id'])
            ->first();

        if ($existingUser) {
            throw new Exception('A user with this email, username, or student ID already exists.');
        }
    }
}

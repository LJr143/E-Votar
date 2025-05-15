<?php

namespace App\Livewire\ManageSystemUser;

use App\Models\User;
use App\Services\ActivityLogger;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddSystemUser extends Component
{
    public $search = '';
    public $users = [];
    public $selectedUser;
    public $currentStep = 1;
    public $selectedRole = null;

    public $user;
    public $roles = [];
    public $permissions = [];
    public $userPermissions = [];
    public $rolePermissions = [];
    public $userId;

    public $username, $password, $confirm_password;

    protected $listeners = ['system-user_added' => '$refresh'];

    // Lifecycle Hooks
    public function mount(): void
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    // Event Handlers
    public function updatedSearch(): void
    {
        $this->users = User::query()
            ->where(function ($query) {
                $query->when($this->search, function ($query) {
                    $matchingUserIds = User::searchEncrypted($this->search, ['first_name', 'last_name'])
                        ->pluck('id');

                    $query->whereIn('id', $matchingUserIds);
                });
            })
            ->whereDoesntHave('roles', fn($query) => $query->whereIn('name', ['superadmin', 'admin', 'watcher', 'technical-officer']))
            ->take(5)
            ->get();
    }

    public function updatedSelectedRole($roleId): void
    {
        if ($roleId) {
            $role = Role::with('permissions')->find($roleId);
            $this->rolePermissions = $role ? $role->permissions : collect();
        } else {
            $this->resetPermissions();
        }
    }

    public function selectUser($userId): void
    {
        $user = User::find($userId);
        if ($user) {
            $this->userId = $user->id;
            $this->selectedUser = $user->id;
            $this->search = $user->first_name . ' ' . $user->middle_initial . '. ' . $user->last_name . ' - ' . $user->year_level . ' ' . $user->program->name;
            $this->users = [];
        }
    }

    public function backToStep1(): void
    {
        $this->currentStep = 1;
    }

    public function proceedToAccessRole(): void
    {
        $this->validate([
            'username' => 'required|min:4|unique:users,username',
            'password' => 'required|min:6|same:confirm_password',
            'selectedUser' => 'required'
        ]);

        $this->currentStep = 2;

        $this->user = User::findOrFail($this->userId);
        $this->roles = Role::with('permissions')->get();
        $this->permissions = Permission::all();

        // Get all permissions (direct and via roles)
        $this->userPermissions = $this->user->getAllPermissions()->pluck('id')->toArray();
        $this->rolePermissions = $this->user->getPermissionsViaRoles();
    }

    /**
     * @throws Exception
     */
    public function togglePermission($permissionName): void
    {
        if (!Permission::where('name', $permissionName)->exists()) {
            throw new Exception('Invalid permission');
        }

        $user = User::find($this->userId);

        // Check current permission status
        if ($user->hasPermissionTo($permissionName)) {
            // If permission comes from role, we can only add direct permission
            if ($user->hasDirectPermission($permissionName)) {
                $user->revokePermissionTo($permissionName);
                session()->flash('success', "Permission '{$permissionName}' has been removed.");
            } else {
                // Permission comes from role, so we add direct permission to override
                $user->givePermissionTo($permissionName);
                session()->flash('success', "Explicit permission '{$permissionName}' has been added (overriding role permission).");
            }
        } else {
            $user->givePermissionTo($permissionName);
            session()->flash('success', "Permission '{$permissionName}' has been added.");
        }

        $this->userPermissions = $user->getAllPermissions()->pluck('id')->toArray();
    }

    public function submit(): void
    {
        $this->validate([
            'username' => 'required|min:3|max:255|unique:users,username',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'selectedRole' => 'required|exists:roles,id',
        ]);

        $user = User::find($this->selectedUser);
        if ($user) {
            $user->update([
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);

        }
        // Detach all roles from the user
        $user->roles()->detach();

        // Assign the selected role
        $user->roles()->attach($this->selectedRole);


        // Sync only selected permissions
        if (!empty($this->userPermissions)) {
            $selectedPermissions = Permission::whereIn('id', $this->userPermissions)->pluck('id');
            $user->permissions()->sync($selectedPermissions);
        }

        $this->reset(['username', 'password', 'confirm_password', 'selectedRole', 'userPermissions']);
        session()->flash('message', 'User created successfully!');
        $this->dispatch('system-user-created');
    }

    private function resetPermissions(): void
    {
        $this->rolePermissions = collect();
        $this->permissions = collect();
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-system-user.add-system-user', [
            'user' => $this->user,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'userPermissions' => $this->userPermissions,
            'rolePermissions' => $this->rolePermissions,
        ]);
    }
}

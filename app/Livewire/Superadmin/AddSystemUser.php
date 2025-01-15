<?php

namespace App\Livewire\Superadmin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddSystemUser extends Component
{
    // Properties
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
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })
            ->whereDoesntHave('roles', fn ($query) => $query->whereIn('name', ['superadmin', 'admin', 'watcher', 'technical-officer']))
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
            $this->search = $user->first_name . ' ' . $user->middle_initial . '. ' . $user->last_name;
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
        $this->userPermissions = $this->user->getDirectPermissions();
        $this->rolePermissions = $this->user->getPermissionsViaRoles();
    }

    public function togglePermission($permissionName): void
    {
        if (!Permission::where('name', $permissionName)->exists()) {
            throw new \Exception('Invalid permission');
        }

        $user = User::find($this->userId);

        // Check if the permission is granted via role
        if ($this->rolePermissions->contains('name', $permissionName)) {
            // Override the role-based permission by directly assigning or revoking
            if ($user->hasDirectPermission($permissionName)) {
                $user->revokePermissionTo($permissionName);
                session()->flash('success', "Permission '{$permissionName}' has been removed.");
            } else {
                $user->givePermissionTo($permissionName);
                session()->flash('success', "Permission '{$permissionName}' has been added.");
            }
        } else {
            // Handle direct user permissions
            if ($user->hasDirectPermission($permissionName)) {
                $user->revokePermissionTo($permissionName);
                session()->flash('success', "Permission '{$permissionName}' has been removed.");
            } else {
                $user->givePermissionTo($permissionName);
                session()->flash('success', "Permission '{$permissionName}' has been added.");
            }
        }

        // Refresh permissions
        $this->userPermissions = $user->getDirectPermissions();
    }

    public function addPermission($permissionName): void
    {
        if (!Permission::where('name', $permissionName)->exists()) {
            Permission::create(['name' => $permissionName]);
        }

        $user = User::find($this->userId);
        $user->givePermissionTo($permissionName);

        session()->flash('success', "Permission '{$permissionName}' has been added and assigned to the user.");
        $this->userPermissions = $user->getDirectPermissions();
    }

    public function removePermission($permissionName): void
    {
        $permission = Permission::where('name', $permissionName)->first();
        if ($permission) {
            $user = User::find($this->userId);
            $user->revokePermissionTo($permissionName);

            session()->flash('success', "Permission '{$permissionName}' has been removed.");
            $this->userPermissions = $user->getDirectPermissions();
        } else {
            session()->flash('error', "Permission '{$permissionName}' does not exist.");
        }
    }

    // Utility Methods
    private function resetPermissions(): void
    {
        $this->rolePermissions = collect();
        $this->permissions = collect();
    }

    public function submit()
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


        // Assign the role and permissions
        $user->roles()->attach($this->selectedRole);
        if (!empty($this->permissions)) {
            $user->permissions()->sync($this->permissions);
        }

        // Reset the form
        $this->reset(['username', 'password', 'confirm_password', 'selectedRole', 'permissions']);
        session()->flash('message', 'User created successfully!');
        $this->dispatch('system-user_added');
    }

    // Rendering
    public function render()
    {
        return view('evotar.livewire.superadmin.add-system-user', [
            'user' => $this->user,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'userPermissions' => $this->userPermissions,
            'rolePermissions' => $this->rolePermissions,
        ]);
    }
}

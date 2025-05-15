<?php

namespace App\Livewire\ManageSystemUser;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EditUser extends Component
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


    public function mount($userId): void
    {
        $this->user = User::find($userId);

        if ($this->user) {
            $this->userId = $this->user->id;
            $this->selectedUser = $this->user->id;
            $this->selectUser($this->userId);
            $this->username = $this->user->username;
            $this->selectedRole = $this->user->roles->pluck('id')->first();
        }

        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

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
        $this->validate(['selectedUser' => 'required']);
        $this->currentStep = 2;
        // Automatically load permissions if editing existing user
        $this->proceedToAccessRole();

        $this->user = User::findOrFail($this->userId);
        $this->userPermissions = $this->user->getDirectPermissions()->pluck('name');
        $this->rolePermissions = $this->user->getPermissionsViaRoles()->pluck('name');
    }


    /**
     * @throws Exception
     */
    public function togglePermission($permissionName): void
    {
        $user = User::findOrFail($this->userId);

        if ($user->hasDirectPermission($permissionName)) {
            $user->revokePermissionTo($permissionName);
        } else {
            $user->givePermissionTo($permissionName);
        }

        // Refresh both types of permissions
        $this->userPermissions = $user->getDirectPermissions()->pluck('name');
        $this->rolePermissions = $user->getPermissionsViaRoles()->pluck('name');
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

    private function resetPermissions(): void
    {
        $this->rolePermissions = collect();
        $this->permissions = collect();
    }

    public function submit(): void
    {
        $this->validate(['selectedRole' => 'required|exists:roles,id']);

        $user = User::find($this->selectedUser);
        $user->syncRoles($this->selectedRole);

        // Refresh permissions after role change
        $this->proceedToAccessRole();
        $this->dispatch('system-user-updated');
    }


    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-system-user.edit-user', ['user' => $this->user]);
    }
}

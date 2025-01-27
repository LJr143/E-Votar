<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'Election Management' => [
                'view election',
                'create election',
                'edit election',
                'delete election',
                'view election results',
                'view vote tally',
            ],
            'Candidate Management' => [
                'create candidate',
                'edit candidate',
                'delete candidate',
                'view candidate',
            ],
            'Party List Management' => [
                'view party list',
                'create party list',
                'edit party list',
                'delete party list',
            ],
            'Voter Management' => [
                'view voter',
                'create voter',
                'edit voter',
                'delete voter',
            ],
            'User Management' => [
                'view users',
                'create users',
                'edit users',
                'delete users',
            ],
            'System Logs' => [
                'view system logs',
                'create system logs',
                'edit system logs',
                'delete system logs',
            ],
        ];

        // Create permissions
        foreach ($permissions as $group => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => $action]);
            }
        }

        // Define roles
        $roles = [
            'superadmin' => [
                'Election Management',
                'Candidate Management',
                'Party List Management',
                'Voter Management',
                'User Management',
                'System Logs',
            ],
        ];

        // Assign permissions to roles dynamically
        foreach ($roles as $roleName => $permissionGroups) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            $rolePermissions = [];
            foreach ($permissionGroups as $groupOrAction) {
                if (is_array($groupOrAction)) {
                    // Add specific permissions
                    $rolePermissions = array_merge($rolePermissions, $groupOrAction);
                } elseif (isset($permissions[$groupOrAction])) {
                    // Add permissions from a group
                    $rolePermissions = array_merge($rolePermissions, $permissions[$groupOrAction]);
                }
            }

            // Sync permissions
            $role->syncPermissions($rolePermissions);
        }

        $this->command->info('Roles and permissions have been successfully assigned!');
    }
}

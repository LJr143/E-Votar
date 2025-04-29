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
                'verify voter',
            ],
            'User Management' => [
                'view users',
                'create users',
                'edit users',
                'delete users',
            ],

            'University Management' => [
                'view colleges',
                'create colleges',
                'edit colleges',
                'delete colleges',
                'view programs',
                'create programs',
                'edit programs',
                'delete programs',
                'view majors',
                'create majors',
                'edit majors',
                'delete majors',
            ],
            'Technical Management' => [
              'view active users',
              'view ip records',
              'print ip records',
              'export ip records',
              'delete ip records',
              'block ip records',
              'allow ip records',
              'view database backup',
              'create database backup',
              'export database backup',
              'delete database backup',
              'run database backup',
            ],
            'Reports Management' => [
              'export election',
              'export election results',
              'export vote tally',
              'export candidates',
              'export positions',
              'export councils',
              'export party list',
              'export voters',
              'export users admin',

            ],

            'Imports Management' => [
                'import election',
                'import positions',
                'import councils',
                'import party list',
                'import voters',
            ],

            'Website Management' => [
                'view website management',
                'create website announcement',
                'view feedback'
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
                Permission::firstOrCreate(['name' => $action, 'guard_name' => 'web']);
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
                'University Management',
                'Reports Management',
                'System Logs',
            ],
            'admin' => [
                'Election Management',
                'Candidate Management',
                'Party List Management',
                'Voter Management',
                'University Management',
                'Reports Management',
                'Imports Management',
                'Website Management',
                'System Logs',
            ],
            'technical_officer' => [
               'Technical Management',
            ],
            'student-council-watcher' => [
                'view vote tally',
                'view election results',
            ],
            'local-council-watcher' => [
                'view vote tally',
                'view election results',
            ],
            'faculty' => [
                'view election',
                'view election results',
                'view vote tally',
                'view candidate',
                'view party list',
                'view system logs',
                'view colleges',
                'view programs',
                'view majors',
                'view vote tally',
                'view election results',
            ],
        ];

        // Assign permissions to roles dynamically
        foreach ($roles as $roleName => $permissionGroups) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            $rolePermissions = [];
            foreach ($permissionGroups as $groupOrAction) {
                if (isset($permissions[$groupOrAction])) {
                    // It's a group name, add all permissions in the group
                    $rolePermissions = array_merge($rolePermissions, $permissions[$groupOrAction]);
                } else {
                    // It's an individual permission, add it directly
                    $rolePermissions[] = $groupOrAction;
                }
            }

            // Sync permissions
            $role->syncPermissions($rolePermissions);
        }

        $this->command->info('Roles and permissions have been successfully assigned!');
    }
}

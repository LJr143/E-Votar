<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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

        // Create permissions and assign them to roles
        foreach ($permissions as $group => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => $action]);
            }
        }

        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $watcher = Role::firstOrCreate(['name' => 'watcher']);

        // Assign specific permissions to roles
        $superadminRole->syncPermissions(array_merge(
            $permissions['Election Management'],
            $permissions['Candidate Management'],
            $permissions['Party List Management'],
            $permissions['Voter Management'],
            $permissions['User Management'],
            $permissions['System Logs']
        ));

        $adminRole->syncPermissions(array_merge(
            $permissions['Candidate Management'],
            ['view vote tally', 'view election results'],
            $permissions['Voter Management'],
            $permissions['Party List Management'],
            ['view system logs']
        ));

        $watcher->syncPermissions([
            'view election',
            'view election results'
        ]);

        $this->command->info('Roles and permissions have been successfully assigned!');
    }
}

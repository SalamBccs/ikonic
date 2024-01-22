<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'=>'student',
            'guard_name'=>'web'
        ]);

        Role::create([
                'name'=>'Operator',
                'guard_name'=>'web'
        ]);

        Role::create([
            'name'=>'Admin',
            'guard_name'=>'web'
        ]);


        $role2 = Role::find(2);
        $role2->givePermissionTo([
            'Users',
            'User Profile',

        ]);

        $role3 = Role::find(3);

        $role3->givePermissionTo([
            'Users',
            'User Profile',
        ]);

    }
}

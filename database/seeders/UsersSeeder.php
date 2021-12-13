<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Normal User', 
            'email' => 'user@example.com',
            'password' => bcrypt('user')
        ]);
  
        $role = Role::create(['name' => 'User']);
   
        $allowedPermissions = [
           'calendar-list',
           'calendar-create',
           'calendar-edit',
           'calendar-delete'
        ];

        $permissions = Permission::whereIn('name', $allowedPermissions)
            ->pluck('id','name')->all();

        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
    }
}

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
        
        $hexColors = ['#1abc9c', '#3498db', '#9b59b6', '#e67e22', '#e74c3c'];

        $users = [
          User::create([
            'name'     => 'Normal User', 
            'email'    => 'user@example.com',
            'password' => bcrypt('user'),
            'color'    => $hexColors[0],
          ]),
          
          User::create([
            'name'     => 'User Two', 
            'email'    => 'user2@example.com',
            'password' => bcrypt('user2'),
            'color'    => $hexColors[1],
          ])
        ];
  
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

        // Assign role to each user   
        foreach ($users as $user) {
          $user->assignRole([$role->id]);
        }

    }
}

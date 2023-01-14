<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $arr_permissions= [
            [
                "name" => "create",
                "slug" => "create"
            ],
            [
                "name" => "read",
                "slug" => "read"
            ],
            [
                "name" => "update",
                "slug" => "update"
            ],
            [
                "name" => "delete",
                "slug" => "delete"
            ]
        ];
        Permission::insert($arr_permissions);
        $roles = Role::create([
            'name' => 'Super Admin',
            'slug' => 'SA'
        ]);
        $permissions = Permission::all();
        $role_permissions = [];
        if(!empty($permissions)){
            foreach ($permissions as $key => $permission) {
                $role_permissions[] = [
                    "role_id" => $roles->id,
                    "permission_id" => $permission->id
                ];
            }
            RolePermission::insert($role_permissions);
        }
        User::factory()->create([
            'name' => 'Dinar Abdul Hollik Firdaus',
            'email' => 'admin@gmail.com',
            'username' => 'dinar',
            'password' => bcrypt('password'),
            'role_id'   => $roles->id,
        ]);
    }
}

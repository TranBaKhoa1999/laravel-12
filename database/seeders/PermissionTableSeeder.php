<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            
            'product-list',
            'product-create',
            'product-edit',
            'product-delete'
         ];
         
         foreach ($permissions as $permission) {
              Permission::firstOrCreate(['name' => $permission]);
         }

        $adminRole = Role::firstOrCreate(['name' => User::ADMIN_ROLE]);
        $userRole = Role::firstOrCreate(['name' => User::USER_ROLE]);
        

        $adminRole->syncPermissions($permissions);
        $userRole->givePermissionTo(['product-list']);
    }
}

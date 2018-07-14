<?php

use Illuminate\Database\Seeder;
use App\{Role, Permission};

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $totalPermissionId   = Permission::where('slug', 'total-administrate')->firstOrFail()->id;
        $viewPermissionId    = Permission::where('slug', 'view-record')->firstOrFail()->id;
        $createPermissionId  = Permission::where('slug', 'create-record')->firstOrFail()->id;
        $updatePermissionId  = Permission::where('slug', 'update-record')->firstOrFail()->id;
        $deletePermissionId  = Permission::where('slug', 'delete-record')->firstOrFail()->id;
        $publishPermissionId = Permission::where('slug', 'publish-record')->firstOrFail()->id;

        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator',
        ])->permissions()->attach([
            $totalPermissionId, $viewPermissionId, $createPermissionId, $updatePermissionId, $deletePermissionId, $publishPermissionId
        ]);

        Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'Post editor',
        ])->permissions()->attach([
            $viewPermissionId, $createPermissionId, $updatePermissionId, $deletePermissionId, $publishPermissionId
        ]);

        Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'description' => 'Content manager',
        ])->permissions()->attach([
            $viewPermissionId, $createPermissionId, $updatePermissionId, $deletePermissionId, $publishPermissionId
        ]);

        Role::create([
            'name' => 'Author',
            'slug' => 'author',
            'description' => 'Post author',
        ])->permissions()->attach([
            $viewPermissionId, $createPermissionId, $updatePermissionId, $deletePermissionId
        ]);

        Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'Simple user',
        ])->permissions()->attach([
            $viewPermissionId
        ]);
    }
}

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
            $viewPermissionId, $createPermissionId, $updatePermissionId, $deletePermissionId, $publishPermissionId
        ]);

        Role::create([
            'name' => 'Author',
            'slug' => 'author',
            'description' => 'Post author',
        ])->permissions()->attach([
            1, 2, 3, 4
        ]);

        Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'Post editor',
        ]);

        Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'description' => 'Content manager',
        ]);

        Role::create([
            'name' => 'Guest',
            'slug' => 'quest',
            'description' => 'Guest for content',
        ]);
    }
}

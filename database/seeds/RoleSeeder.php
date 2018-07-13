<?php

use Illuminate\Database\Seeder;
use App\Role;

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
            'name' => 'Author',
            'slug' => 'author',
            'description' => 'Post author',
            'permissions' => [
                'create-post' => true,
            ]
        ]);
        Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'Post editor',
            'permissions' => [
                'update-post' => true,
                'publish-post' => true,
            ]
        ]);
        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator',
            'permissions' => [
                'administrate' => true,
                'update-post' => true,
                'publish-post' => true,
            ]
        ]);
    }
}

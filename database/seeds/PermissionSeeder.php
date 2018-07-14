<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Total administrate',
            'slug' => 'total-administrate',
            'description' => 'Total administrate of users and content',
        ]);

        Permission::create([
            'name' => 'View record',
            'slug' => 'view-record',
            'description' => 'Permission to view record',
        ]);

        Permission::create([
            'name' => 'Create record',
            'slug' => 'create-record',
            'description' => 'Permission to create record',
        ]);

        Permission::create([
            'name' => 'Update record',
            'slug' => 'update-record',
            'description' => 'Permission to update record',
        ]);

        Permission::create([
            'name' => 'Delete record',
            'slug' => 'delete-record',
            'description' => 'Permission to delete record',
        ]);

        Permission::create([
            'name' => 'Publish record',
            'slug' => 'publish-record',
            'description' => 'Permission to publish record',
        ]);
    }
}

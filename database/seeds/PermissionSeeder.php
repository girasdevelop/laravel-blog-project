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
            'name' => 'Create record',
            'slug' => 'create_record',
            'description' => 'Permission to create record',
        ]);
        Permission::create([
            'name' => 'Update record',
            'slug' => 'update_record',
            'description' => 'Permission to update record',
        ]);
        Permission::create([
            'name' => 'Delete record',
            'slug' => 'delete_record',
            'description' => 'Permission to delete record',
        ]);
    }
}

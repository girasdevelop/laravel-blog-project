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
        $this->createRecord(
            'Administrate',
            'administrate',
            'Total administrate of users and content'
        );

        $this->createRecord(
            'View record',
            'view-record',
            'Permission to view record'
        );

        $this->createRecord(
            'Create record',
            'create-record',
            'Permission to create record'
        );

        $this->createRecord(
            'Update record',
            'update-record',
            'Permission to update record'
        );

        $this->createRecord(
            'Delete record',
            'delete-record',
            'Permission to delete record'
        );

        $this->createRecord(
            'Publish record',
            'publish-record',
            'Permission to publish record'
        );
    }

    /**
     * @param string $name
     * @param string $slug
     * @param string $description
     */
    private function createRecord(string $name, string $slug, string $description)
    {
        Permission::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
        ]);
    }
}

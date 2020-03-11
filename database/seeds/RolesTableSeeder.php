<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin
        DB::table('roles')->insert([
            'name' => \App\Role::ADMIN,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // customer
        DB::table('roles')->insert([
            'name' => \App\Role::CUSTOMER,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // first helper
        DB::table('roles')->insert([
            'name' => \App\Role::FIRST_HELPER,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // second helper
        DB::table('roles')->insert([
            'name' => \App\Role::SECOND_HELPER,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}

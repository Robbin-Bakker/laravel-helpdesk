<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // role id's [name] = id
        $roles = DB::table('roles')->pluck('id', 'name');

        if($roles){
            // Admin user
            DB::table('users')->insert([
                'name' => 'Ad Min',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'role_id' => $roles[\App\Role::ADMIN],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Customer users
            DB::table('users')->insert([
                'name' => 'Karel Klant',
                'email' => 'klant1@gmail.com',
                'password' => bcrypt('klant1'),
                'role_id' => $roles[\App\Role::CUSTOMER],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'name' => 'Kees Koper',
                'email' => 'klant2@gmail.com',
                'password' => bcrypt('klant2'),
                'role_id' => $roles[\App\Role::CUSTOMER],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // First helper users
            DB::table('users')->insert([
                'name' => 'Jan Helpman',
                'email' => 'firsthelper1@gmail.com',
                'password' => bcrypt('firsthelper1'),
                'role_id' => $roles[\App\Role::FIRST_HELPER],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'name' => 'Henk Hulp',
                'email' => 'firsthelper2@gmail.com',
                'password' => bcrypt('firsthelper2'),
                'role_id' => $roles[\App\Role::FIRST_HELPER],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Second helper users
            DB::table('users')->insert([
                'name' => 'Teun Steun',
                'email' => 'secondhelper1@gmail.com',
                'password' => bcrypt('secondhelper1'),
                'role_id' => $roles[\App\Role::SECOND_HELPER],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('users')->insert([
                'name' => 'Fred Red',
                'email' => 'secondhelper2@gmail.com',
                'password' => bcrypt('secondhelper2'),
                'role_id' => $roles[\App\Role::SECOND_HELPER],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}

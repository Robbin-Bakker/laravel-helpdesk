<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // firstline
        DB::table('statuses')->insert([
            'name' => \App\Status::FIRST_LINE,
            'description' => \App\Status::FIRST_LINE_DESC,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // firstline assigned
        DB::table('statuses')->insert([
            'name' => \App\Status::FIRST_LINE_ASSIGNED,
            'description' => \App\Status::FIRST_LINE_ASSIGNED_DESC,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // secondline
        DB::table('statuses')->insert([
            'name' => \App\Status::SECOND_LINE,
            'description' => \App\Status::SECOND_LINE_DESC,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // secondline assigned
        DB::table('statuses')->insert([
            'name' => \App\Status::SECOND_LINE_ASSIGNED,
            'description' => \App\Status::SECOND_LINE_ASSIGNED_DESC,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // closed
        DB::table('statuses')->insert([
            'name' => \App\Status::CLOSED,
            'description' => \App\Status::CLOSED_DESC,
            'created_at' => now(),
            'updated_at' => now()
        ]);


    }
}

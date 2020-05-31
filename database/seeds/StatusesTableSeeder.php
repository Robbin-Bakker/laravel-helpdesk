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
            'description' => 'ticket wacht op een eerstelijns medewerker',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // firstline assigned
        DB::table('statuses')->insert([
            'name' => \App\Status::FIRST_LINE_ASSIGNED,
            'description' => 'ticket is toegewezen aan eerstelijns medewerker',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // secondline
        DB::table('statuses')->insert([
            'name' => \App\Status::SECOND_LINE,
            'description' => 'ticket wacht op een tweedelijns medewerker',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // secondline assigned
        DB::table('statuses')->insert([
            'name' => \App\Status::SECOND_LINE_ASSIGNED,
            'description' => 'ticket is toegewezen aan tweedelijns medewerker',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // closed
        DB::table('statuses')->insert([
            'name' => \App\Status::CLOSED,
            'description' => 'ticket is afgehandeld',
            'created_at' => now(),
            'updated_at' => now()
        ]);


    }
}

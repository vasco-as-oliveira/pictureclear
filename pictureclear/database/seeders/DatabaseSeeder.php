<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Course::factory(10)->create();
        \App\Models\Tier::factory(10)->create();
        \App\Models\Schedule::factory(10)->create();


        /*$courses = DB::select("SELECT id from courses");
        foreach ($courses as $id){
            \App\Models\Course::factory(10)->create();
        }*/
        


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

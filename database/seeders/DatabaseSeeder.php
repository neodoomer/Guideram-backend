<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Expert;
use App\Models\Consultation;
use Illuminate\Database\Seeder;
use App\Models\Consultation_type;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(10)->create();
        DB::table('consultation_types')->insert([
            'type' => 'Medical'
        ]);
        DB::table('consultation_types')->insert([
            'type' => 'Professional'
        ]);
        DB::table('consultation_types')->insert([
            'type' => 'Psychological'
        ]);
        DB::table('consultation_types')->insert([
            'type' => 'Familial'
        ]);
        DB::table('consultation_types')->insert([
            'type' => 'Business'
        ]);
    }
}

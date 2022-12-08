<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Expert;
use Illuminate\Database\Seeder;
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
        Expert::factory(10)->create();
        User::factory(10)->create();
    }
}

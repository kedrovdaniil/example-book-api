<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate all rows in table
        User::truncate();

        // Seed new rows
        User::factory()->times(14)->create();
    }
}

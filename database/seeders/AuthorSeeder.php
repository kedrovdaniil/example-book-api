<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate all rows in table
        Author::truncate();

        // Seed new rows
        Author::factory()->times(14)->create();
    }
}

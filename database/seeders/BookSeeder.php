<?php

namespace Database\Seeders;

use App\Models\AuthorBook;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate all rows in table
        Book::truncate();

        // Seed new rows
        Book::factory()->times(14)->create();

        // Seed artisan pivot table ('author_book')
        AuthorBook::truncate();
        for ($i = 1; $i <= 14; $i++) {
            AuthorBook::insert([
                'author_id' => $i,
                'book_id' => $i
            ]);
        }
    }
}

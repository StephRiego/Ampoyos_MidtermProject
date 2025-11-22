<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Example: create 5 sample books
        Book::factory()->count(5)->create();
    }
}

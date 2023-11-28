<?php

namespace Database\Seeders;

use App\Models\Book;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=0; $i<20; $i++){
            $books = new Book;

            $books->isbn = $faker->randomNumber(9);
            $books->title = $faker->name;
            $books->year = rand(2010,2021);

            $books->publisher_id = rand(1,20);
            $books->author_id = rand(1,20);
            $books->catalog_id = rand(1,4);

            $books->qty = rand(10,20);
            $books->price = rand(10000,20000);

            $books->save();
        }
    }
}

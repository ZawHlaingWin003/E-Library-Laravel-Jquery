<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ['Biography', 'Fiction', 'Humor', 'Mystery', 'Travel Literature', 'Literary Fiction', 'Romance', 'Horror', 'Poetry', 'Religion'];

        foreach($genres as $genre){
            Genre::create([
                'name' => $genre
            ]);
        }
    }
}

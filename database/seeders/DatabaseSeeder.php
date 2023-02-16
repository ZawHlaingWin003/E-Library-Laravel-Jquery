<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Genre;
use App\Models\AdminUser;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UserSeeder::class,
            AdminUserSeeder::class,
            GenreSeeder::class,
        ]);

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Traits\Scraping\AreaScrapingTrait;

class DatabaseSeeder extends Seeder
{
    use AreaScrapingTrait;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        AreaScrapingTrait::init();
        // \App\Models\User::factory(10)->create();
    }
}

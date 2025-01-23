<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Tworzenie 10 losowych pozycji menu
        Menu::factory()->count(10)->create();
    }
}
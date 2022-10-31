<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Card::factory()->create([
            'name' => 'Agregar subtareas al kanban',
            'status' => 1
        ]);
        Card::factory()->create([
            'name' => 'Testing Kanban',
            'status' => 2
        ]);
        Card::factory()->count(10)->create();
    }
}

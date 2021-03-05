<?php

namespace Database\Seeders;

use App\Models\Whence;
use Illuminate\Database\Seeder;

class WhenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Facebook'],
            ['name' => 'Instagram'],
            ['name' => 'Google'],
            ['name' => 'sklep stacjonarny'],
            ['name' => 'sklep online'],
            ['name' => 'od znajomego'],
            ['name' => 'od sprzedawcy']
        ];
        Whence::factory()->createMany($data);
    }
}

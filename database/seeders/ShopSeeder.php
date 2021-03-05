<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Media Expert'],
            ['name' => 'RTV EURO AGD'],
            ['name' => 'Media Markt'],
            ['name' => 'Neonet'],
            ['name' => 'Electro'],
            ['name' => 'Avans'],
            ['name' => 'neo24.pl'],
            ['name' => 'oleole.pl'],
            ['name' => 'Komputronik'],
            ['name' => 'maxelektro.pl'],
            ['name' => 'mambonus.pl'],
            ['name' => 'payback.pl'],
            ['name' => 'zadowolenie.pl'],
            ['name' => 'kakto.pl'],
            ['name' => 'al.to'],
            ['name' => 'leclerc.pl'],
            ['name' => 'strefa.enea.pl'],
            ['name' => 'mycenter.pl'],
            ['name' => 'mediadomek.pl'],
            ['name' => 'agdperfekt.pl'],
            ['name' => 'karen.pl'],
            ['name' => 'Oficjalny sklep Media Markt na Allegro'],
            ['name' => 'Oficjalny sklep Electro na Allegro'],
            ['name' => 'Oficjalny sklep Avans na Allegro'],
            ['name' => 'Oficjalny sklep OleOle na Allegro'],
            ['name' => 'Oficjalny sklep Neo24 na Allegro'],
            ['name' => 'empik'],
            ['name' => 'morele.net']
        ];

        Shop::factory()->createMany($data);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'code' => 'S9001',
                'name' => 'Hydraluxe PRO',
                'text' => 'Przesuszone, łamliwe i puszące się włosy? To przeszłość! Specjalna budowa płytki z odżywką Moisture Lock zadba o prawidłowe nawilżenie włosów, a innowacyjna chłodna mgiełka ochroni każde pasmo przed działaniem wysokiej temperatury.',
                'urls' => [
                    'https://mediamarkt.pl/agd-male/prostownica-do-wlosow-remington-s9001-hydraluxe-pro',
                    'https://www.mediaexpert.pl/agd-male/zdrowie-i-uroda/karbownice-i-prostownice/prostownica-remington-s9001-hydraluxe-pro',
                    'https://www.euro.com.pl/prostownice-i-karbownice/remington-hydraluxe-pro-s9001.bhtml',
                    'https://www.neonet.pl/prostownice-i-karbownice/remington-s9001-hydraluxe.html'
                ]
            ],
            [
                'code' => 'S8901',
                'name' => 'HYDRAluxe',
                'text' => 'Ta wyjątkowa prostownica wykorzystuje unikalną technologię powłoki płytek Moisture Lock, by nawilżać Twoje włosy od nasady aż po same końce, a ustawienie temperatury Hydracare zapewnia idealną, zdrową temperaturę stylizacji.',
                'urls' => [
                    'https://mediamarkt.pl/agd-male/prostownica-do-wlosow-remington-s8901-hydraluxe',
                    'https://www.mediaexpert.pl/agd-male/zdrowie-i-uroda/karbownice-i-prostownice/prostownica-remington-s8901-hydraluxe',
                    'https://www.euro.com.pl/prostownice-i-karbownice/remington-hydraluxe-s8901.bhtml',
                    'https://www.neonet.pl/prostownice-i-karbownice/remington-s8901-hydraluxe.html'
                ]
            ],
            [
                'code' => 'S6606',
                'name' => 'CURL & STRAIGHT CONFIDENCE',
                'text' => 'Dzięki unikalnej i intuicyjnej konstrukcji 2 w 1 prostownicą Curl & Straight Confidence możesz tworzyć fale i loki lub uzyskać efekt super gładkich, prostych włosów.',
                'urls' => [
                    'https://www.euro.com.pl/prostownice-i-karbownice/remington-s6606.bhtml',
                    'https://www.mediaexpert.pl/agd-male/zdrowie-i-uroda/karbownice-i-prostownice/prostownica-remington-s6606-curl-confidance',
                    'https://www.euro.com.pl/prostownice-i-karbownice/remington-s6606.bhtml'
                ]
            ],
            [
                'code' => 'S8598',
                'name' => 'KERATIN PROTECT',
                'text' => 'Inteligentna prostownica Keratin Protect przez cały czas wykrywa unikalny poziom wilgoci włosów i dostosowuje ciepło dla optymalnej temperatury stylizacji, co daje 3x większą ochronę*, mniej uszkodzeń i zdrowsze włosy*.<br><br>* w porównaniu ze standardową prostownicą Remington bez czujnika temperatury',
                'urls' => [
                    'https://www.mediaexpert.pl/agd-male/zdrowie-i-uroda/karbownice-i-prostownice/prostownica-remington-s8598-keratin-protect',
                    'https://www.euro.com.pl/prostownice-i-karbownice/remington-s8598-keratin-protect.bhtml',
                    'https://www.neonet.pl/prostownice-i-karbownice/remington-s8598-keratin-protect.html'
                ]
            ],
            [
                'code' => 'S8605',
                'name' => 'ADVANCED COLOUR PROTECT',
                'text' => 'Inteligentna prostownica Advanced Colour Protect dzięki powłoce ceramicznej zawierającej olej Shea i filtry UV zadba o zdrowy wygląd Twoich włosów.',
                'urls' => [
                    'https://mediamarkt.pl/agd-male/prostownica-remington-s8605-advance-colour-protect',
                    'https://www.neonet.pl/prostownice-i-karbownice/remington-s8605-colour-protect.html'
                ]
            ],
            [
                'code' => 'S8540',
                'name' => 'KERATIN PROTECT - CHANNEL',
                'text' => 'Prostownica Keratin Protect posiada zaawansowaną technologię ceramiczną wzbogaconą keratyną i olejem migdałowym, które podczas stylizowania uwalniają się na włosy, dzięki czemu są one mocne, lśniące i wyglądają zdrowo.',
                'urls' => [
                    'https://www.neonet.pl/prostownice-i-karbownice/remington-s8540.html',
                    'https://www.komputronik.pl/product/427239/remington-s8540-keratin-protect.html'
                ]
            ],
            [
                'code' => 'S5408',
                'name' => 'MINERAL GLOW',
                'text' => 'Z prostownicą Mineral Glow, dzięki zaawansowanej powłoce ceramicznej pokrytej czterema naturalnymi minerałami - kwarcem, turmalinem, opalem i kamieniem księżycowym, zawsze będziesz mogła cieszyć się pięknymi, prostymi włosami.',
                'urls' => [
                    'https://www.neonet.pl/prostownice-i-karbownice/remington-prostownica-mineral-glow-s5408.html',
                    'https://www.mycenter.pl/prostownica-remington-s5408-mineral-glow,id-183501'
                ]
            ],
            [
                'code' => 'S9100',
                'name' => 'PROLUXE',
                'text' => 'Inteligentna technologia OPTIHeat wykorzystana w tym urządzeniu zapewnia maksymalną trwałość fryzury. Posiada ono płytki z powłoką ceramiczną, które zapewniają do 5 razy większą gładkość.*<br><br>*w porównaniu ze standardową powłoką ceramiczną',
                'urls' => [
                    'https://mediamarkt.pl/agd-male/prostownica-remington-s9100-proluxe',
                    'https://www.mediaexpert.pl/agd-male/zdrowie-i-uroda/karbownice-i-prostownice/prostownica-remington-s9100-proluxe',
                    'https://www.euro.com.pl/prostownice-i-karbownice/remington-pro-luxe-s9100.bhtml',
                    'https://www.neonet.pl/prostownice-i-karbownice/remington-proluxe-s9100.html'
                ]
            ],
            [
                'code' => 'S9300',
                'name' => 'SHINE THERAPY PRO',
                'text' => 'Urządzenie wyposażone zostało w potrójną technologię: zaawansowaną powłokę ceramiczną, technologię jonową Super Ionic oraz profesjonalny system dystrybucji ciepła. Dzięki nim osiągniesz idealną gładkość bez efektu naelektryzowania.',
                'urls' => [
                    'https://www.mediaexpert.pl/agd-male/zdrowie-i-uroda/karbownice-i-prostownice/prostownica-remington-s9300-shine-therapy-pro',
                    'https://www.euro.com.pl/prostownice-i-karbownice/remington-remi-prostownica-s9300-shine-therapy-pro.bhtml'
                ]
            ],
            [
                'code' => 'S5901',
                'name' => 'COCONUT SMOOTH',
                'text' => 'Prostownica Coconut Smooth wyposażona została w zaawansowane płytki z powłoką ceramiczną z mikro-odżywkami wzbogaconymi kokosem, dzięki czemu zapewnia całodzienną ochronę przed puszeniem.',
                'urls' => []
            ],
            [
                'code' => 'S7970',
                'name' => 'WET2STRAIGHT',
                'text' => 'Urządzenie idealne dla aktywnych kobiet prowadzących intensywny tryb życia. Dzięki technologii WET2STRAIGHT gwarantuje zdrowe rezultaty prostowania bez konieczności czasochłonnego etapu suszenia włosów.',
                'urls' => []
            ],
            [
                'code' => 'S9700',
                'name' => 'SALON COLLECTION',
                'text' => 'Prostownica Salon Collection wyposażona jest w podwójny system grzewczy zapewniający szybkie i równomierne nagrzewanie podczas stylizacji. Zaawansowane płytki ceramiczne z powłoką Ultimate Glide zapewniają idealne gładkie rezultaty.',
                'urls' => [
                    'https://maxelektro.pl/sklep/karta-produktu/prostownica-remington-s9700,67481.html',
                ]
            ],
            [
                'code' => 'S7307',
                'name' => 'AQUALISSE EXTREME',
                'text' => 'Dzięki podgrzewanym płytkom prostownicy Aqualisse Extrême, które odparowują nadmiar wody przez specjalnie zaprojektowane otwory wentylacyjne, można prostować i suszyć włosy w tym samym czasie!',
                'urls' => [
                    'https://maxelektro.pl/sklep/karta-produktu/prostownica-remington-s7307,74198.html'
                ]
            ],
            [
                'code' => 'S6700',
                'name' => 'SLEEK & CURL EXPERT',
                'text' => 'Masz dość wyboru między eleganckimi, prostymi włosami, a bujnymi lokami? Jeśli tak, to Sleek & Curl Expert stanie się Twoim nowym ulubionym urządzeniem do stylizacji. Pozwala ono bez wysiłku tworzyć zarówno proste włosy, jak i loki.',
                'urls' => [
                    'https://www.euro.com.pl/prostownice-i-karbownice/remington-s6700.bhtml',
                    'https://www.neonet.pl/prostownice-i-karbownice/remington-prostownica-s6700.html'
                ]
            ],
        ];

        foreach ($products as $product) {
            $urls = $product['urls'];

            unset($product['urls']);

            $row = Product::factory()->create($product);

            foreach ($urls as $url) {
                Link::factory()->create([
                    'url' => $url,
                    'product_id' => $row->id
                ]);
            }
        }

    }
}

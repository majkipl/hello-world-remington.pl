<?php

namespace App\Enums;

class ShopType
{
    const STATIONARY = 'sklep stajnonarny';

    const ONLINE = 'sklep online';

    const TYPES = [
        self::STATIONARY,
        self::ONLINE
    ];
}

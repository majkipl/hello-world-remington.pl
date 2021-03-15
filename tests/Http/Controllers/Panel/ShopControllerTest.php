<?php

namespace Http\Controllers\Panel;

use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Panel\PanelBaseTestCase;

class ShopControllerTest extends PanelBaseTestCase
{
    use RefreshDatabase;

    public $route = 'back.shop';

    public $model = Shop::class;
}

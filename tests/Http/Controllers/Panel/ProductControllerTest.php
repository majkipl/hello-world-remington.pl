<?php

namespace Http\Controllers\Panel;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Panel\PanelBaseTestCase;

class ProductControllerTest extends PanelBaseTestCase
{
    use RefreshDatabase;

    public $route = 'back.product';

    public $model = Product::class;
}

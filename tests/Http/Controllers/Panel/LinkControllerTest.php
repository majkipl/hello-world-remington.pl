<?php

namespace Http\Controllers\Panel;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Panel\PanelBaseTestCase;

class LinkControllerTest extends PanelBaseTestCase
{
    use RefreshDatabase;

    public $route = 'back.link';

    public $model = Link::class;
}

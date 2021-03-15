<?php

namespace Http\Controllers\Panel;

use App\Models\Whence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Panel\PanelBaseTestCase;

class WhenceControllerTest extends PanelBaseTestCase
{
    use RefreshDatabase;

    public $route = 'back.whence';

    public $model = Whence::class;
}

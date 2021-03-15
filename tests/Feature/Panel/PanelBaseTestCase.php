<?php

namespace Tests\Feature\Panel;

use Illuminate\Database\Eloquent\Model;
use Tests\Feature\Api\Authenticated\AuthenticatedTestCase;

class PanelBaseTestCase extends AuthenticatedTestCase
{
    public $route;
    public $model;

    /** @test */
    public function user_has_not_access_to_index()
    {
        $this->user_has_not_access($this->route);
    }

    /** @test */
    public function user_has_access_to_index()
    {
        $this->user_has_access($this->route);
    }

    /** @test */
    public function user_has_not_access_to_create()
    {
        $this->user_has_not_access($this->route . '.create');
    }

    /** @test */
    public function user_has_access_to_create()
    {
        $this->user_has_access($this->route . '.create');
    }

    /** @test */
    public function user_has_not_access_to_show()
    {
        $item = ($this->model)::factory()->create();

        $this->user_has_not_access($this->route . '.show', [$item->id]);
    }

    /** @test */
    public function user_has_access_to_show()
    {
        $item = ($this->model)::factory()->create();

        $this->user_has_access($this->route . '.show', [$item->id]);
    }

    /** @test */
    public function user_has_access_to_show_and_not_exist_id()
    {
        $this->user_has_not_access($this->route . '.show', [999]);
    }

    /** @test */
    public function user_has_not_access_to_edit()
    {
        $item = ($this->model)::factory()->create();

        $this->user_has_not_access($this->route . '.edit', [$item->id]);
    }

    /** @test */
    public function user_has_access_to_edit()
    {
        $item = ($this->model)::factory()->create();

        $this->user_has_access($this->route . '.edit', [$item->id]);
    }

    /** @test */
    public function user_has_access_to_edit_and_not_exist_id()
    {
        $this->user_has_not_access($this->route . '.edit', [999]);
    }
}

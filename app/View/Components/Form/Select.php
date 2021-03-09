<?php

namespace App\View\Components\Form;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $name = null,
        public $items = [],
        public $class = null,
        public $classWrapper = null,
        public $error = '',
        public $max = null,
        public $placeholder = '',
        public $required = false,
        public $selected = null
    )
    {
        $this->name = $name ?? 'form_select_' . Str::random(8);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}

<?php

namespace App\View\Components\Form\Input;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class File extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $name = null,
        public $class = null,
        public $error = '',
        public $required = false,
    )
    {
        $this->name = $name ?? 'form_input_' . Str::random(8);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input.file');
    }
}

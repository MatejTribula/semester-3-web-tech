<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Filter extends Component
{
    public $name;

    public $options;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  array  $options
     */
    public function __construct($name = 'filter', $options = [])
    {
        $this->name = $name;
        $this->options = $options;
    }

    public function render()
    {
        return view('components.filter');
    }
}

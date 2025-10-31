<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardSection extends Component
{
    public $title;

    public $filterName;

    public $filterOptions;

    public $cards;

    public function __construct($title, $filterName = null, $filterOptions = [], $cards = [])
    {
        $this->title = $title;
        $this->filterName = $filterName;
        $this->filterOptions = $filterOptions;
        $this->cards = $cards;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-section');
    }
}

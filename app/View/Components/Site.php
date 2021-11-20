<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Site extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $header;

    public function __construct($name, $header=null)
    {
        $this->name = $name;
        $this->header = $header;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.site');
    }
}

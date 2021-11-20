<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Page extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $name;
    public $body;

    public function __construct($name, $body=null)
    {
        $this->name = $name;
        $this->body = $body;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.page');
    }
}

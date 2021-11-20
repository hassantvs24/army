<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $label;
    public $id;
    public $required;
    public $rest;
    public $class;

    public function __construct($name, $label, $class=null, $rest=null, $id=null, $required=null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
        $this->required = $required;
        $this->rest = $rest;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.select');
    }
}

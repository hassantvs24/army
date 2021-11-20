<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $label;
    public $type;
    public $id;
    public $required;
    public $value;
    public $rest;
    public $class;

    public function __construct($name, $label, $type='text', $value=null, $class=null, $rest=null, $id=null, $required=null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->id = $id;
        $this->required = $required;
        $this->value = $value;
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
        return view('components.input');
    }
}

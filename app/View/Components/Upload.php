<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Upload extends Component
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
    public $accept;
    public $rest;

    public function __construct($name, $label, $accept=null, $rest=null, $id=null, $required=null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
        $this->required = $required;
        $this->accept = $accept;
        $this->rest = $rest;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.upload');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id;
    public $title;
    public $icon;
    public $bg;
    public $size;
    public $action;

    public function __construct($id, $title, $icon, $bg='primary',  $size='', $action=null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->icon = $icon;
        $this->bg = $bg;
        $this->size = $size;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Signature extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $left;
    public $right;
    public function __construct($left = null, $right = null)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.signature');
    }
}

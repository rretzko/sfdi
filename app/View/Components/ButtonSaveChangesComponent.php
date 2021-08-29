<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonSaveChangesComponent extends Component
{
    public $value;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value='Save Changes')
    {
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.button-save-changes-component');
    }
}

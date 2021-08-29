<?php

namespace App\View\Components;

use Illuminate\View\Component;

class buttonDossierSectionHeaderComponent extends Component
{
    /**
     * Button's href
     */
    public $href;
    
    /**
     * Button's value property
     */
    public $value;
    
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($href='dashboard', $value='Edit')
    {
        $this->value = $value;
        $this->href = url($href);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.button-dossier-section-header-component');
    }
}

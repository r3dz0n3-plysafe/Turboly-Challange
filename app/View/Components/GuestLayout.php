<?php

namespace App\View\Components;

use App\Traits\AdaptiveView;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    use AdaptiveView;
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return $this->renderView('layouts.guest');
    }
}

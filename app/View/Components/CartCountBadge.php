<?php

namespace App\View\Components;

use App\Models\AddToCartModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CartCountBadge extends Component
{
    /**
     * Create a new component instance.
     */
    public $count;

    public function __construct()
    {
        //
        if (Auth::check()) {
            $this->count = AddToCartModel::where('email', Auth::user()->email)
                ->count();
        } else {
            $this->count = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-count-badge');
    }
}

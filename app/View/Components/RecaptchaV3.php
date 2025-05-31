<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecaptchaV3 extends Component
{
    public function __construct(public string $action = 'submit') {}

    public function render()
    {
        return view('components.recaptcha-v3');
    }
}

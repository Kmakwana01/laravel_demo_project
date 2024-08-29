<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class message extends Component
{
    public $msg;

    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    public function render(): View|Closure|string
    {
        return view('components.message',['msg'=>$this->msg]);
    }
}

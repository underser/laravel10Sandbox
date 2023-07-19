<?php

namespace App\View\Components\Crm\Admin;

use Illuminate\View\Component;
use Illuminate\View\View;

class MainLayout extends Component
{
    public function render(): View
    {
        return view('layouts.crm.admin.main');
    }
}

<?php

namespace App\View\Components\Backend;

use Illuminate\View\Component;

class Status extends Component
{
    public $id, $status, $route;

    public function __construct($id, $status, $route = null)
    {
        $this->id = $id;
        $this->status = $status;
        $this->route = $route;
    }

    public function render()
    {
        return view(backendComponent('status'));
    }
}

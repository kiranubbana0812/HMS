<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableSerial extends Component
{
    public $loop;
    public $paginator;

    public function __construct($loop, $paginator = null)
    {
        $this->loop = $loop;
        $this->paginator = $paginator;
    }

    public function render()
    {
        return view('components.table-serial');
    }

    public function number()
    {
        if ($this->paginator) {
            return ($this->paginator->currentPage() - 1) * $this->paginator->perPage() + $this->loop->iteration;
        }

        return $this->loop->iteration;
    }
}

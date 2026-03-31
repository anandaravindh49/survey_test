<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Livewire\Component;

class Show extends Component
{
    public Machine $machine;

    public function render()
    {
        return view('livewire.machines.show');
    }
}

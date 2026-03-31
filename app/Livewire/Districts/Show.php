<?php

namespace App\Livewire\Districts;

use App\Models\District;
use Livewire\Component;

class Show extends Component
{
    public $district;

    public function mount(District $district)
    {
        $this->district = $district;
    }

    public function render()
    {
        return view('livewire.districts.show');
    }
}

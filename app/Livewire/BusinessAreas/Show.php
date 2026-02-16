<?php

namespace App\Livewire\BusinessAreas;

use App\Models\BusinessArea;
use Livewire\Component;

class Show extends Component
{
    public BusinessArea $businessArea;

    public function render()
    {
        return view('livewire.business-areas.show', [
            'businessArea' => $this->businessArea,
        ]);
    }
}

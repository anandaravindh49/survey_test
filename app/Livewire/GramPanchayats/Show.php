<?php

namespace App\Livewire\GramPanchayats;

use App\Models\GramPanchayat;
use Livewire\Component;

class Show extends Component
{
    public GramPanchayat $gramPanchayat;

    public function mount(GramPanchayat $gramPanchayat)
    {
        $this->gramPanchayat = $gramPanchayat;
    }

    public function render()
    {
        return view('livewire.gram-panchayats.show');
    }
}

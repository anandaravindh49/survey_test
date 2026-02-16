<?php

namespace App\Livewire\Blocks;

use App\Models\Block;
use Livewire\Component;

class Show extends Component
{
    public Block $block;

    public function render()
    {
        return view('livewire.blocks.show');
    }
}

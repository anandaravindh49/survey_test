<?php

namespace App\Livewire\Blocks;

use App\Models\Block;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public Block $block;

    public $package_name = '';
    public $state_name = '';
    public $business_area = '';
    public $district_name = '';
    public $block_name = '';
    public $code = '';
    public $status = 'ACTIVE';

    public function mount()
    {
        $this->package_name = $this->block->package_name;
        $this->state_name = $this->block->state_name;
        $this->business_area = $this->block->business_area;
        $this->district_name = $this->block->district_name;
        $this->block_name = $this->block->block_name;
        $this->code = $this->block->code;
        $this->status = $this->block->status;
    }

    public function save()
    {
        $this->validate([
            'package_name' => 'required|string',
            'state_name' => 'required|string',
            'business_area' => 'nullable|string',
            'district_name' => 'required|string',
            'block_name' => 'required|string',
            'code' => 'required|string|unique:blocks,code,' . $this->block->id,
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        $this->block->update([
            'package_name' => $this->package_name,
            'state_name' => $this->state_name,
            'business_area' => $this->business_area,
            'district_name' => $this->district_name,
            'block_name' => $this->block_name,
            'code' => $this->code,
            'status' => $this->status,
            'updated_by' => Auth::id(),
        ]);

        session()->flash('message', 'Block updated successfully.');
        return redirect()->route('blocks.index');
    }

    public function render()
    {
        return view('livewire.blocks.edit');
    }
}

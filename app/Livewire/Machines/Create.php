<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $package_name = '';
    public $state_name = '';
    public $business_area = '';
    public $district_name = '';
    public $block_name = '';
    public $machine_name = '';
    public $machine_type = '';
    public $code = '';
    public $status = 'ACTIVE';

    public function save()
    {
        $this->validate([
            'package_name' => 'required|string',
            'state_name' => 'required|string',
            'business_area' => 'nullable|string',
            'district_name' => 'required|string',
            'block_name' => 'required|string',
            'machine_name' => 'required|string',
            'machine_type' => 'nullable|string',
            'code' => 'required|string|unique:machines',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        Machine::create([
            'package_name' => $this->package_name,
            'state_name' => $this->state_name,
            'business_area' => $this->business_area,
            'district_name' => $this->district_name,
            'block_name' => $this->block_name,
            'machine_name' => $this->machine_name,
            'machine_type' => $this->machine_type,
            'code' => $this->code,
            'status' => $this->status,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        session()->flash('message', 'Machine created successfully.');
        return redirect()->route('machines.index');
    }

    public function render()
    {
        return view('livewire.machines.create');
    }
}

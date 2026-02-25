<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public Machine $machine;
    public $package_name = '';
    public $state_name = '';
    public $business_area = '';
    public $district_name = '';
    public $block_name = '';
    public $machine_name = '';
    public $machine_type = '';
    public $code = '';
    public $status = 'ACTIVE';

    public function mount(Machine $machine)
    {
        $this->machine = $machine;
        $this->package_name = $machine->package_name;
        $this->state_name = $machine->state_name;
        $this->business_area = $machine->business_area;
        $this->district_name = $machine->district_name;
        $this->block_name = $machine->block_name;
        $this->machine_name = $machine->machine_name;
        $this->machine_type = $machine->machine_type;
        $this->code = $machine->code;
        $this->status = $machine->status;
    }

    public function update()
    {
        $this->validate([
            'package_name' => 'required|string',
            'state_name' => 'required|string',
            'business_area' => 'nullable|string',
            'district_name' => 'required|string',
            'block_name' => 'required|string',
            'machine_name' => 'required|string',
            'machine_type' => 'nullable|string',
            'code' => 'required|string|unique:machines,code,' . $this->machine->id,
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        $this->machine->update([
            'package_name' => $this->package_name,
            'state_name' => $this->state_name,
            'business_area' => $this->business_area,
            'district_name' => $this->district_name,
            'block_name' => $this->block_name,
            'machine_name' => $this->machine_name,
            'machine_type' => $this->machine_type,
            'code' => $this->code,
            'status' => $this->status,
            'updated_by' => Auth::id(),
        ]);

        session()->flash('message', 'Machine updated successfully.');
        return redirect()->route('machines.index');
    }

    public function render()
    {
        return view('livewire.machines.edit');
    }
}

<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public Machine $machine;
    public $package_name = '';
    public $machine_state = '';
    public $business_area = '';
    public $machine_district = '';
    public $machine_block = '';
    public $make = '';
    public $serial_no = '';
    public $operator_name = '';
    public $mobile = '';
    public $operator_id = '';
    public $machine_type = '';
    public $code = '';
    public $status = 'ACTIVE';

    public function mount(Machine $machine)
    {
        $this->machine = $machine;
        $this->package_name = $machine->package_name;
        $this->machine_state = $machine->machine_state;
        $this->business_area = $machine->business_area;
        $this->machine_district = $machine->machine_district;
        $this->machine_block = $machine->machine_block;
        $this->make = $machine->make;
        $this->serial_no = $machine->serial_no;
        $this->operator_name = $machine->operator_name;
        $this->mobile = $machine->mobile;
        $this->operator_id = $machine->operator_id;
        $this->machine_type = $machine->machine_type;
        $this->code = $machine->code;
        $this->status = $machine->status;
    }

    public function update()
    {
        $this->validate([
            'package_name' => 'required|string',
            'machine_state' => 'required|string',
            'business_area' => 'nullable|string',
            'machine_district' => 'required|string',
            'machine_block' => 'required|string',
            'make' => 'required|string',
            'serial_no' => 'nullable|string',
            'operator_name' => 'nullable|string',
            'mobile' => 'nullable|string',
            'operator_id' => 'nullable|string',
            'machine_type' => 'nullable|string',
            'code' => 'required|string|unique:machines,code,' . $this->machine->id,
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        $this->machine->update([
            'package_name' => $this->package_name,
            'machine_state' => $this->machine_state,
            'business_area' => $this->business_area,
            'machine_district' => $this->machine_district,
            'machine_block' => $this->machine_block,
            'make' => $this->make,
            'serial_no' => $this->serial_no,
            'operator_name' => $this->operator_name,
            'mobile' => $this->mobile,
            'operator_id' => $this->operator_id,
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

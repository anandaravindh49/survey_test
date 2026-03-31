<?php

namespace App\Livewire\Districts;

use App\Models\District;
use Livewire\Component;

class Create extends Component
{
    public $package_name = '';
    public $state_name = '';
    public $business_area = '';
    public $district_name = '';
    public $code = '';
    public $status = 'ACTIVE';

    protected $rules = [
        'package_name' => 'required|string|max:255',
        'state_name' => 'required|string|max:255',
        'business_area' => 'nullable|string|max:255',
        'district_name' => 'required|string|max:255',
        'code' => 'required|string|max:255|unique:districts',
        'status' => 'required|in:ACTIVE,INACTIVE',
    ];

    protected $validationAttributes = [
        'package_name' => 'Package Name',
        'state_name' => 'State Name',
        'business_area' => 'Business Area',
        'district_name' => 'District Name',
        'code' => 'Code',
        'status' => 'Status',
    ];

    public function save()
    {
        $this->validate();

        District::create([
            'package_name' => $this->package_name,
            'state_name' => $this->state_name,
            'business_area' => $this->business_area,
            'district_name' => $this->district_name,
            'code' => $this->code,
            'status' => $this->status,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'District created successfully!');
        return redirect()->route('districts.index');
    }

    public function render()
    {
        return view('livewire.districts.create');
    }
}

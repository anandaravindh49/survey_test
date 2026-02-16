<?php

namespace App\Livewire\Districts;

use App\Models\District;
use Livewire\Component;

class Edit extends Component
{
    public $district;
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
        'code' => 'required|string|max:255',
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

    public function mount(District $district)
    {
        $this->district = $district;
        $this->package_name = $district->package_name;
        $this->state_name = $district->state_name;
        $this->business_area = $district->business_area;
        $this->district_name = $district->district_name;
        $this->code = $district->code;
        $this->status = $district->status;
    }

    public function save()
    {
        $this->validate();

        $this->district->update([
            'package_name' => $this->package_name,
            'state_name' => $this->state_name,
            'business_area' => $this->business_area,
            'district_name' => $this->district_name,
            'code' => $this->code,
            'status' => $this->status,
            'updated_by' => auth()->id(),
        ]);

        session()->flash('message', 'District updated successfully!');
        return redirect()->route('districts.index');
    }

    public function render()
    {
        return view('livewire.districts.edit');
    }
}

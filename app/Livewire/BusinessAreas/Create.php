<?php

namespace App\Livewire\BusinessAreas;

use App\Models\BusinessArea;
use Livewire\Component;

class Create extends Component
{
    public $package_name = '';
    public $state_name = '';
    public $business_name = '';
    public $code = '';
    public $status = 'ACTIVE';

    protected $rules = [
        'package_name' => 'required|string|max:255',
        'state_name' => 'required|string|max:255',
        'business_name' => 'required|string|max:255',
        'code' => 'required|string|unique:business_areas,code|max:50',
        'status' => 'required|in:ACTIVE,INACTIVE',
    ];

    protected $messages = [
        'package_name.required' => 'Package name is required',
        'state_name.required' => 'State name is required',
        'business_name.required' => 'Business name is required',
        'code.required' => 'Code is required',
        'code.unique' => 'This code already exists',
        'status.required' => 'Status is required',
    ];

    public function save()
    {
        $this->validate();

        BusinessArea::create([
            'package_name' => $this->package_name,
            'state_name' => $this->state_name,
            'business_name' => $this->business_name,
            'code' => $this->code,
            'status' => $this->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('business-areas.index')->with('success', 'Business Area created successfully!');
    }

    public function render()
    {
        return view('livewire.business-areas.create');
    }
}

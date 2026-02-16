<?php

namespace App\Livewire\BusinessAreas;

use App\Models\BusinessArea;
use Livewire\Component;

class Edit extends Component
{
    public BusinessArea $businessArea;
    public $package_name;
    public $state_name;
    public $business_name;
    public $code;
    public $status;

    protected function rules()
    {
        return [
            'package_name' => 'required|string|max:255',
            'state_name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:business_areas,code,' . $this->businessArea->id,
            'status' => 'required|in:ACTIVE,INACTIVE',
        ];
    }

    protected $messages = [
        'package_name.required' => 'Package name is required',
        'state_name.required' => 'State name is required',
        'business_name.required' => 'Business name is required',
        'code.required' => 'Code is required',
        'code.unique' => 'This code already exists',
        'status.required' => 'Status is required',
    ];

    public function mount()
    {
        $this->package_name = $this->businessArea->package_name;
        $this->state_name = $this->businessArea->state_name;
        $this->business_name = $this->businessArea->business_name;
        $this->code = $this->businessArea->code;
        $this->status = $this->businessArea->status;
    }

    public function save()
    {
        $this->validate();

        $this->businessArea->update([
            'package_name' => $this->package_name,
            'state_name' => $this->state_name,
            'business_name' => $this->business_name,
            'code' => $this->code,
            'status' => $this->status,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('business-areas.index')->with('success', 'Business Area updated successfully!');
    }

    public function render()
    {
        return view('livewire.business-areas.edit', [
            'businessArea' => $this->businessArea,
        ]);
    }
}

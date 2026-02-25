<?php

namespace App\Livewire\GramPanchayats;

use App\Models\GramPanchayat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public GramPanchayat $gramPanchayat;

    public $state_name = '';
    public $business_area = '';
    public $district_name = '';
    public $block_name = '';
    public $gp_name = '';
    public $gp_code = '';
    public $gp_type = '';
    public $status = '';

    protected $rules = [
        'state_name' => 'required|string|max:255',
        'business_area' => 'required|string|max:255',
        'district_name' => 'required|string|max:255',
        'block_name' => 'required|string|max:255',
        'gp_name' => 'required|string|max:255',
        'gp_code' => 'required|string|max:255',
        'gp_type' => 'nullable|string|max:255',
        'status' => 'required|in:ACTIVE,INACTIVE',
    ];

    public function mount(GramPanchayat $gramPanchayat)
    {
        $this->gramPanchayat = $gramPanchayat;
        $this->state_name = $gramPanchayat->state_name;
        $this->business_area = $gramPanchayat->business_area;
        $this->district_name = $gramPanchayat->district_name;
        $this->block_name = $gramPanchayat->block_name;
        $this->gp_name = $gramPanchayat->gp_name;
        $this->gp_code = $gramPanchayat->gp_code;
        $this->gp_type = $gramPanchayat->gp_type;
        $this->status = $gramPanchayat->status;
    }

    public function save()
    {
        $this->validate();

        $this->gramPanchayat->update([
            'state_name' => $this->state_name,
            'business_area' => $this->business_area,
            'district_name' => $this->district_name,
            'block_name' => $this->block_name,
            'gp_name' => $this->gp_name,
            'gp_code' => $this->gp_code,
            'gp_type' => $this->gp_type,
            'status' => $this->status,
            'updated_by' => Auth::id(),
        ]);

        session()->flash('message', 'Gram Panchayat updated successfully.');

        return redirect()->route('gram-panchayats.index');
    }

    public function render()
    {
        $states = GramPanchayat::distinct()->pluck('state_name')->filter()->sort();
        $businessAreas = GramPanchayat::distinct()->pluck('business_area')->filter()->sort();
        $districts = GramPanchayat::distinct()->pluck('district_name')->filter()->sort();
        $blocks = GramPanchayat::distinct()->pluck('block_name')->filter()->sort();
        $gpTypes = GramPanchayat::distinct()->pluck('gp_type')->filter()->sort();

        return view('livewire.gram-panchayats.edit', [
            'states' => $states,
            'businessAreas' => $businessAreas,
            'districts' => $districts,
            'blocks' => $blocks,
            'gpTypes' => $gpTypes,
        ]);
    }
}

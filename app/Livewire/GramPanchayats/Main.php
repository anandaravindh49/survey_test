<?php

namespace App\Livewire\GramPanchayats;

use App\Models\GramPanchayat;
use Livewire\Component;
use Livewire\WithPagination;

class Main extends Component
{
    use WithPagination;

    public $search = '';
    public $filterState = '';
    public $filterBusinessArea = '';
    public $filterDistrict = '';
    public $filterBlock = '';
    public $filterGpType = '';
    public $filterStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['gramPanchayatDeleted' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterState()
    {
        $this->filterBusinessArea = '';
        $this->filterDistrict = '';
        $this->filterBlock = '';
        $this->resetPage();
    }

    public function updatingFilterBusinessArea()
    {
        $this->filterDistrict = '';
        $this->filterBlock = '';
        $this->resetPage();
    }

    public function updatingFilterDistrict()
    {
        $this->filterBlock = '';
        $this->resetPage();
    }

    public function updatingFilterBlock()
    {
        $this->resetPage();
    }

    public function updatingFilterGpType()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function sort($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterState = '';
        $this->filterBusinessArea = '';
        $this->filterDistrict = '';
        $this->filterBlock = '';
        $this->filterGpType = '';
        $this->filterStatus = '';
        $this->resetPage();
    }

    public function delete($id)
    {
        GramPanchayat::find($id)->delete();
        $this->dispatch('gramPanchayatDeleted');
    }

    public function render()
    {
        $gramPanchayats = GramPanchayat::query()
            ->when($this->search, function ($q) {
                $q->where('gp_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('gp_code', 'ilike', '%' . $this->search . '%')
                    ->orWhere('gp_type', 'ilike', '%' . $this->search . '%')
                    ->orWhere('state_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('business_area', 'ilike', '%' . $this->search . '%')
                    ->orWhere('district_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('block_name', 'ilike', '%' . $this->search . '%');
            })
            ->when($this->filterState, function ($q) {
                $q->where('state_name', $this->filterState);
            })
            ->when($this->filterBusinessArea, function ($q) {
                $q->where('business_area', $this->filterBusinessArea);
            })
            ->when($this->filterDistrict, function ($q) {
                $q->where('district_name', $this->filterDistrict);
            })
            ->when($this->filterBlock, function ($q) {
                $q->where('block_name', $this->filterBlock);
            })
            ->when($this->filterGpType, function ($q) {
                $q->where('gp_type', $this->filterGpType);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        // Get unique values for filter dropdowns
        $states = GramPanchayat::distinct()->pluck('state_name')->filter()->sort();
        
        if ($this->filterState) {
            $businessAreas = GramPanchayat::where('state_name', $this->filterState)
                ->distinct()->pluck('business_area')->filter()->sort();
        } else {
            $businessAreas = GramPanchayat::distinct()->pluck('business_area')->filter()->sort();
        }

        if ($this->filterBusinessArea) {
            $districts = GramPanchayat::where('business_area', $this->filterBusinessArea)
                ->distinct()->pluck('district_name')->filter()->sort();
        } else {
            $districts = GramPanchayat::distinct()->pluck('district_name')->filter()->sort();
        }

        if ($this->filterDistrict) {
            $blocks = GramPanchayat::where('district_name', $this->filterDistrict)
                ->distinct()->pluck('block_name')->filter()->sort();
        } else {
            $blocks = GramPanchayat::distinct()->pluck('block_name')->filter()->sort();
        }

        $gpTypes = GramPanchayat::distinct()->pluck('gp_type')->filter()->sort();

        // Calculate totals
        $totalStates = GramPanchayat::distinct()->count('state_name');
        $totalBusinessAreas = GramPanchayat::distinct()->count('business_area');
        $totalDistricts = GramPanchayat::distinct()->count('district_name');
        $totalBlocks = GramPanchayat::distinct()->count('block_name');
        $totalGramPanchayats = GramPanchayat::count();

        return view('livewire.gram-panchayats.main', [
            'gramPanchayats' => $gramPanchayats,
            'states' => $states,
            'businessAreas' => $businessAreas,
            'districts' => $districts,
            'blocks' => $blocks,
            'gpTypes' => $gpTypes,
            'totalStates' => $totalStates,
            'totalBusinessAreas' => $totalBusinessAreas,
            'totalDistricts' => $totalDistricts,
            'totalBlocks' => $totalBlocks,
            'totalGramPanchayats' => $totalGramPanchayats,
        ]);
    }
}

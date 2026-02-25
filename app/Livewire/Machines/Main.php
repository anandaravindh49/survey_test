<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Livewire\Component;
use Livewire\WithPagination;

class Main extends Component
{
    use WithPagination;

    public $search = '';
    public $filterPackage = '';
    public $filterState = '';
    public $filterDistrict = '';
    public $filterBlock = '';
    public $filterStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['machineDeleted' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPackage()
    {
        $this->filterState = '';
        $this->filterDistrict = '';
        $this->filterBlock = '';
        $this->resetPage();
    }

    public function updatingFilterState()
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
        $this->filterPackage = '';
        $this->filterState = '';
        $this->filterDistrict = '';
        $this->filterBlock = '';
        $this->filterStatus = '';
        $this->resetPage();
    }

    public function delete($id)
    {
        Machine::find($id)->delete();
        $this->dispatch('machineDeleted');
    }

    public function render()
    {
        $machines = Machine::query()
            ->when($this->search, function ($q) {
                $q->where('machine_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('code', 'ilike', '%' . $this->search . '%')
                    ->orWhere('machine_type', 'ilike', '%' . $this->search . '%')
                    ->orWhere('package_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('state_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('district_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('block_name', 'ilike', '%' . $this->search . '%');
            })
            ->when($this->filterPackage, function ($q) {
                $q->where('package_name', $this->filterPackage);
            })
            ->when($this->filterState, function ($q) {
                $q->where('state_name', $this->filterState);
            })
            ->when($this->filterDistrict, function ($q) {
                $q->where('district_name', $this->filterDistrict);
            })
            ->when($this->filterBlock, function ($q) {
                $q->where('block_name', $this->filterBlock);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        // Get unique values for filter dropdowns
        $packages = Machine::distinct()->pluck('package_name')->filter()->sort();
        
        if ($this->filterPackage) {
            $states = Machine::where('package_name', $this->filterPackage)
                ->distinct()->pluck('state_name')->filter()->sort();
        } else {
            $states = Machine::distinct()->pluck('state_name')->filter()->sort();
        }

        if ($this->filterState) {
            $districts = Machine::where('state_name', $this->filterState)
                ->distinct()->pluck('district_name')->filter()->sort();
        } else {
            $districts = Machine::distinct()->pluck('district_name')->filter()->sort();
        }

        if ($this->filterDistrict) {
            $blocks = Machine::where('district_name', $this->filterDistrict)
                ->distinct()->pluck('block_name')->filter()->sort();
        } else {
            $blocks = Machine::distinct()->pluck('block_name')->filter()->sort();
        }

        // Calculate totals
        $totalPackages = Machine::distinct()->count('package_name');
        $totalStates = Machine::distinct()->count('state_name');
        $totalDistricts = Machine::distinct()->count('district_name');
        $totalBlocks = Machine::distinct()->count('block_name');
        $totalMachines = Machine::count();

        return view('livewire.machines.main', [
            'machines' => $machines,
            'packages' => $packages,
            'states' => $states,
            'districts' => $districts,
            'blocks' => $blocks,
            'totalPackages' => $totalPackages,
            'totalStates' => $totalStates,
            'totalDistricts' => $totalDistricts,
            'totalBlocks' => $totalBlocks,
            'totalMachines' => $totalMachines,
        ]);
    }
}

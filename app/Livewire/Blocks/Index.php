<?php

namespace App\Livewire\Blocks;

use App\Models\Block;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterPackage = '';
    public $filterState = '';
    public $filterDistrict = '';
    public $filterStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['blockDeleted' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPackage()
    {
        // Reset state filter when package changes
        $this->filterState = '';
        $this->filterDistrict = '';
        $this->resetPage();
    }

    public function updatingFilterState()
    {
        // Reset district filter when state changes
        $this->filterDistrict = '';
        $this->resetPage();
    }

    public function updatingFilterDistrict()
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
        $this->filterStatus = '';
        $this->resetPage();
    }

    public function delete($id)
    {
        Block::find($id)->delete();
        $this->dispatch('blockDeleted');
    }

    public function render()
    {
        $blocks = Block::query()
            ->when($this->search, function ($q) {
                $q->where('block_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('code', 'ilike', '%' . $this->search . '%')
                    ->orWhere('package_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('state_name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('district_name', 'ilike', '%' . $this->search . '%');
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
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        // Get unique packages for filter dropdown
        $packages = Block::distinct()->pluck('package_name')->sort();
        
        // Get states based on selected package, or all states if no package selected
        if ($this->filterPackage) {
            $states = Block::where('package_name', $this->filterPackage)
                ->distinct()
                ->pluck('state_name')
                ->sort();
        } else {
            $states = Block::distinct()->pluck('state_name')->sort();
        }

        // Get districts based on selected state, or all districts if no state selected
        if ($this->filterState) {
            $districts = Block::where('state_name', $this->filterState)
                ->distinct()
                ->pluck('district_name')
                ->sort();
        } else {
            $districts = Block::distinct()->pluck('district_name')->sort();
        }

        // Calculate totals
        $totalPackages = Block::distinct()->count('package_name');
        $totalStates = Block::distinct()->count('state_name');
        $totalDistricts = Block::distinct()->count('district_name');
        $totalBlocks = Block::count();

        return view('livewire.blocks.index', [
            'blocks' => $blocks,
            'packages' => $packages,
            'states' => $states,
            'districts' => $districts,
            'totalPackages' => $totalPackages,
            'totalStates' => $totalStates,
            'totalDistricts' => $totalDistricts,
            'totalBlocks' => $totalBlocks,
        ]);
    }
}

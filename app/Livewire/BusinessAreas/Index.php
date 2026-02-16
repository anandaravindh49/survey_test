<?php

namespace App\Livewire\BusinessAreas;

use App\Models\BusinessArea;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterPackage = '';
    public $filterState = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['businessAreaDeleted' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPackage()
    {
        // Reset state filter when package changes
        $this->filterState = '';
        $this->resetPage();
    }

    public function updatingFilterState()
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
        $this->resetPage();
    }

    public function delete($id)
    {
        BusinessArea::find($id)->delete();
        $this->dispatch('businessAreaDeleted');
    }

    public function render()
    {
        $businessAreas = BusinessArea::query()
            ->when($this->search, function ($q) {
                $q->where('business_name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterPackage, function ($q) {
                $q->where('package_name', $this->filterPackage);
            })
            ->when($this->filterState, function ($q) {
                $q->where('state_name', $this->filterState);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        // Get unique packages for filter dropdown
        $packages = BusinessArea::distinct()->pluck('package_name')->sort();
        
        // Get states based on selected package, or all states if no package selected
        if ($this->filterPackage) {
            $states = BusinessArea::where('package_name', $this->filterPackage)
                ->distinct()
                ->pluck('state_name')
                ->sort();
        } else {
            $states = BusinessArea::distinct()->pluck('state_name')->sort();
        }

        return view('livewire.business-areas.index', [
            'businessAreas' => $businessAreas,
            'packages' => $packages,
            'states' => $states,
        ]);
    }
}

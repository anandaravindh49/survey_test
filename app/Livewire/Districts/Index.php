<?php

namespace App\Livewire\Districts;

use App\Models\District;
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

    protected $listeners = ['districtDeleted' => '$refresh'];

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
        District::find($id)->delete();
        $this->dispatch('districtDeleted');
    }

    public function render()
    {
        $districts = District::query()
            ->when($this->search, function ($q) {
                $q->where('district_name', 'like', '%' . $this->search . '%')
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
        $packages = District::distinct()->pluck('package_name')->sort();
        
        // Get states based on selected package, or all states if no package selected
        if ($this->filterPackage) {
            $states = District::where('package_name', $this->filterPackage)
                ->distinct()
                ->pluck('state_name')
                ->sort();
        } else {
            $states = District::distinct()->pluck('state_name')->sort();
        }

        return view('livewire.districts.index', [
            'districts' => $districts,
            'packages' => $packages,
            'states' => $states,
        ]);
    }
}

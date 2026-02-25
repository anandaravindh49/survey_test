<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Main extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterRole = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    protected $queryString = ['search', 'sortBy', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterRole = '';
        $this->resetPage();
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($userId)
    {
        User::find($userId)->delete();
        session()->flash('message', 'User deleted successfully!');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterRole, function ($query) {
                $query->where('role', $this->filterRole);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        // User stats
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'ACTIVE')->count();
        $inactiveUsers = User::where('status', 'INACTIVE')->count();
        $suspendedUsers = User::where('status', 'SUSPENDED')->count();

        return view('livewire.users.main', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'suspendedUsers' => $suspendedUsers,
        ]);
    }
}

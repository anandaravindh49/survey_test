<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

    // Edit modal properties
    public $showEditModal = false;
    public $editUserId = null;
    public $editForm = [
        'name' => '',
        'email' => '',
        'mobile' => '',
        'role' => '',
        'states' => '',
        'nodal' => 'NO',
        'status' => 'ACTIVE',
        'password' => '',
        'password_confirmation' => '',
    ];

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

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->editUserId = $userId;
        $this->editForm = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'role' => $user->role,
            'states' => $user->states,
            'nodal' => $user->nodal,
            'status' => $user->status,
            'password' => '',
            'password_confirmation' => '',
        ];
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editUserId = null;
        $this->editForm = [
            'name' => '',
            'email' => '',
            'mobile' => '',
            'role' => '',
            'states' => '',
            'nodal' => 'NO',
            'status' => 'ACTIVE',
            'password' => '',
            'password_confirmation' => '',
        ];
        $this->resetErrorBag();
    }

    public function updateUser()
    {
        $rules = [
            'editForm.name' => 'required|string|max:255',
            'editForm.email' => 'required|email|unique:users,email,' . $this->editUserId,
            'editForm.mobile' => 'nullable|string|max:20',
            'editForm.role' => 'nullable|string|max:255',
            'editForm.states' => 'nullable|string|max:255',
            'editForm.nodal' => 'required|in:YES,NO',
            'editForm.status' => 'required|in:ACTIVE,INACTIVE,SUSPENDED',
            'editForm.password' => 'nullable|min:8|confirmed',
        ];

        $this->validate($rules);

        $user = User::findOrFail($this->editUserId);
        
        $data = [
            'name' => $this->editForm['name'],
            'email' => $this->editForm['email'],
            'mobile' => $this->editForm['mobile'],
            'role' => $this->editForm['role'],
            'states' => $this->editForm['states'],
            'nodal' => $this->editForm['nodal'],
            'status' => $this->editForm['status'],
        ];

        if (!empty($this->editForm['password'])) {
            $data['password'] = Hash::make($this->editForm['password']);
        }

        $user->update($data);

        session()->flash('message', 'User updated successfully!');
        $this->closeEditModal();
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

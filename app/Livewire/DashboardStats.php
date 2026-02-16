<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class DashboardStats extends Component
{
    public $totalUsers = 0;
    public $activeUsers = 0;
    public $inactiveUsers = 0;
    public $suspendedUsers = 0;

    protected $listeners = ['updateStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalUsers = User::count();
        $this->activeUsers = User::where('status', 'ACTIVE')->count();
        $this->inactiveUsers = User::where('status', 'INACTIVE')->count();
        $this->suspendedUsers = User::where('status', 'SUSPENDED')->count();
    }

    public function updateStats()
    {
        $this->loadStats();
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}

<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\BusinessArea;
use App\Models\District;
use App\Models\Block;
use App\Models\Machine;
use App\Models\GramPanchayat;
use Livewire\Component;

class DashboardStats extends Component
{
    // User stats
    public $totalUsers = 0;
    public $activeUsers = 0;
    public $inactiveUsers = 0;
    public $suspendedUsers = 0;

    // Master data stats
    public $totalBusinessAreas = 0;
    public $totalDistricts = 0;
    public $totalBlocks = 0;
    public $totalMachines = 0;
    public $totalGramPanchayats = 0;

    // Active counts
    public $activeBusinessAreas = 0;
    public $activeDistricts = 0;
    public $activeBlocks = 0;
    public $activeMachines = 0;
    public $activeGramPanchayats = 0;

    protected $listeners = ['updateStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // User stats
        $this->totalUsers = User::count();
        $this->activeUsers = User::where('status', 'ACTIVE')->count();
        $this->inactiveUsers = User::where('status', 'INACTIVE')->count();
        $this->suspendedUsers = User::where('status', 'SUSPENDED')->count();

        // Master data stats
        $this->totalBusinessAreas = BusinessArea::count();
        $this->activeBusinessAreas = BusinessArea::where('status', 'ACTIVE')->count();

        $this->totalDistricts = District::count();
        $this->activeDistricts = District::where('status', 'ACTIVE')->count();

        $this->totalBlocks = Block::count();
        $this->activeBlocks = Block::where('status', 'ACTIVE')->count();

        $this->totalMachines = Machine::count();
        $this->activeMachines = Machine::where('status', 'ACTIVE')->count();

        $this->totalGramPanchayats = GramPanchayat::count();
        $this->activeGramPanchayats = GramPanchayat::where('status', 'ACTIVE')->count();
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

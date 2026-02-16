<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $mobile = '';
    public $role = '';
    public $nodal = 'NO';
    public $states = '';
    public $status = 'ACTIVE';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'mobile' => 'nullable|string|max:20',
        'role' => 'nullable|string|max:255',
        'nodal' => 'required|in:YES,NO',
        'states' => 'nullable|string|max:255',
        'status' => 'required|in:ACTIVE,INACTIVE,SUSPENDED',
        'password' => 'required|min:8|confirmed',
    ];

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'nodal' => $this->nodal,
            'states' => $this->states,
            'status' => $this->status,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'User created successfully!');
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}

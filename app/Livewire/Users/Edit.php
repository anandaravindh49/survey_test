<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public User $user;
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
        'email' => 'required|email|unique:users,email',
        'mobile' => 'nullable|string|max:20',
        'role' => 'nullable|string|max:255',
        'nodal' => 'required|in:YES,NO',
        'states' => 'nullable|string|max:255',
        'status' => 'required|in:ACTIVE,INACTIVE,SUSPENDED',
        'password' => 'nullable|min:8|confirmed',
    ];

    public function mount()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->mobile = $this->user->mobile;
        $this->role = $this->user->role;
        $this->nodal = $this->user->nodal;
        $this->states = $this->user->states;
        $this->status = $this->user->status;
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['email'] = 'required|email|unique:users,email,' . $this->user->id;

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'nodal' => $this->nodal,
            'states' => $this->states,
            'status' => $this->status,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        session()->flash('message', 'User updated successfully!');
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}

<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use App\Models\User;

class Index extends Component
{
    public function render()
    {
        return view('livewire.user-management.index', [
            'users' => User::with('roles')->paginate(10),
        ]);
    }

}

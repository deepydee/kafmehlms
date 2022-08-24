<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Tests extends Component
{
    public function render()
    {
        Gate::allowIf(fn ($user) => $user->user_role === 'admin' || $user->user_role === 'teacher');
        return view('livewire.tests');
    }
}

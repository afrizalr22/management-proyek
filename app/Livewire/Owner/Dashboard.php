<?php

namespace App\Livewire\Owner;

use Livewire\Component;
use App\Livewire\Actions\Logout;

class Dashboard extends Component
{
    public function logout(Logout $logout)
    {
        $logout();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.owner.dashboard');
    }
}
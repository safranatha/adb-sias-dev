<?php

namespace App\Livewire\Proposal;

use App\Models\Proposal;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        // dd(Proposal::all());
        return view('livewire.proposal.index', [
            'proposals' => Proposal::all(),
        ]);
    }
}

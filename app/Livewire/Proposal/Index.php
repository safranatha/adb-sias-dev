<?php

namespace App\Livewire\Proposal;

use App\Models\Proposal;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public function render()
    {
        // dd(Proposal::all());
        return view('livewire.proposal.index', [
            'proposals' => Proposal::with(['tender', 'user'])->paginate(5),
        ]);
    }
}

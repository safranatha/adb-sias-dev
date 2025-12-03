<?php

namespace App\Livewire\Tender;

use App\Models\Tender;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.tender.index', [
            'tenders' => Tender::all(),
        ]);
    }
}

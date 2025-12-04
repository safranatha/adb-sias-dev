<?php

namespace App\Livewire\InternalMemo;

use Livewire\Component;
use App\Models\InternalMemo;

class Index extends Component
{
    public function render()
    {
        return view('livewire.internal-memo.index',[
            'internalMemos' => InternalMemo::all(),
        ]);
    }
}

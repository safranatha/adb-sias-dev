<?php

namespace App\Livewire\TrackingDocument;

use Livewire\Component;
use function Livewire\Volt\title;

class Detail extends Component
{
    public function render()
    {
        return view('livewire.tracking-document.detail')->title('Detail Tracking');
    }

    public function backToIndex()
    {
        return redirect()->route('tracking-document.index');
    }

}

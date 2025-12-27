<?php

namespace App\Livewire\FormTugas;

use App\Models\FormTugas;
use Livewire\Component;

class Penerima extends Component
{
    public function render()
    {
        return view('livewire.form-tugas.penerima', [
            'formtugas_penerima' => FormTugas::whereHas('disposisis', function ($q) {
                $q->where('penerima_id', auth()->user()->id);
            })->get(),

        ]);
    }
}

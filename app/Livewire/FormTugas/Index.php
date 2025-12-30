<?php

namespace App\Livewire\FormTugas;

use App\Models\FormTugas;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';


    public function render()
    {
        return view('livewire.form-tugas.index', [
            'formtugas_direktur' => FormTugas::whereHas('disposisis', function ($q) {
                $q->whereIn('penerima_id', [4, 5]);
            })->get(),
            'formtugas_manajer_teknik' => FormTugas::whereHas('disposisis', function ($q) {
                $q->where('penerima_id', 6);
            })->get(),
            'formtugas_manajer_admin' => FormTugas::whereHas('disposisis', function ($q) {
                $q->where('penerima_id', 7);
            })->get(),
            

        ])->title('Daftar Form Tugas');
    }
}

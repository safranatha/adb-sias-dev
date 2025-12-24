<?php

namespace App\Livewire\FormTugas;

use App\Models\FormTugas;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';


    public function download($id)
    {
        $form_tugas = FormTugas::findOrFail($id);

        if (!$form_tugas) {
            return session()->flash('error', 'Form Tugas tidak ditemukan.');
        }

        $file_path = public_path('storage/' . $form_tugas->file_path_form_tugas);

        if (!file_exists($file_path)) {
            return session()->flash('error', 'File Form Tugas tidak ditemukan di storage.');
        }

        return response()->download($file_path);
    }
    public function render()
    {
        return view('livewire.form-tugas.index', [
            'formtugas' => FormTugas::all(),
        ])->title('Daftar Form Tugas');
    }
}

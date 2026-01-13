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
        $user = auth()->user();
        $role_name = $user->getRoleNames()->first();
        // $penerima_id_direktur = [];
        // // yang diget hanya manajer admin dan teknik
        // $penerima_id_direktur = [4, 5];
        // $formtugas_direktur = FormTugas::whereHas('disposisis', function ($q) use ($penerima_id_direktur) {
        //     $q->whereIn('penerima_id', $penerima_id_direktur);
        // })->get();
        $formtugas_direktur = FormTugas::whereHas('disposisis.user.roles', function ($q) {
            $q->where('name', 'Manajer Admin')->orWhere('name', 'Manajer Teknik');
        })->get();

        $formtugas_manajer_teknik = FormTugas::whereHas('disposisis.user.roles', function ($q) {
            $q->where('name', 'Staff Teknik');
        })->get();

        $formtugas_manajer_admin = FormTugas::whereHas('disposisis.user.roles', function ($q) {
            $q->where('name', 'Staff Admin');
        })->get();


        return view('livewire.form-tugas.index', [
            'formtugas_direktur' => $formtugas_direktur,
            'formtugas_manajer_teknik' => $formtugas_manajer_teknik,
            'formtugas_manajer_admin' => $formtugas_manajer_admin,
        ])->title('Daftar Form Tugas');
    }
}

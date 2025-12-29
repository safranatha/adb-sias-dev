<?php

namespace App\Livewire\FormTugas;

use App\Helpers\DokumenTenderHelper;
use App\Models\Disposisi;
use App\Models\FormTugas;
use Livewire\Component;

class Detail extends Component
{
    public $form_tugas_id;

    public function mount($id)
    {
        $this->form_tugas_id = $id;
        $this->timestamp_baca($id);
    }

    public function download($id)
    {
        return DokumenTenderHelper::downloadHelper(FormTugas::class, $id, 'file_path_form_tugas', 'File Form Tugas');
    }

    public function timestamp_baca($id)
    {
        // check apakah sudah baca apa belum
        $disposisi = Disposisi::where('form_tugas_id', '=', $id)->first();

        if (!$disposisi->waktu_disposisi_dibaca) {
            $user_id = auth()->user()->id;

            $penerima_id_on_disposisi = Disposisi::where('form_tugas_id', '=', $id)->first()->penerima_id;

            if ($user_id === $penerima_id_on_disposisi) {
                // update waktu_dibaca_disposisi on disposisi table
                Disposisi::where('form_tugas_id', '=', $id)->update(['waktu_disposisi_dibaca' => now(), 'status' => '1']);
            }
        }


    }

    public function updateStatus($id)
    {
        // check ulang terkait user idnya
        $user_id = auth()->user()->id;
        $penerima_id_on_disposisi = Disposisi::where('form_tugas_id', '=', $id)->first()->penerima_id;
        if ($user_id === $penerima_id_on_disposisi) {
            // update status on disposisi table
            Disposisi::where('form_tugas_id', '=', $id)->update(['status' => '2']);
        }
    }

    public function render()
    {
        return view('livewire.form-tugas.detail', [
            'formtugas' => FormTugas::find($this->form_tugas_id),
        ]);
    }
}

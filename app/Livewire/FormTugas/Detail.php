<?php

namespace App\Livewire\FormTugas;

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

    public function timestamp_baca($id){
        $user_id=auth()->user()->id;

        $penerima_id_on_disposisi=Disposisi::where('form_tugas_id','=',$id)->first()->penerima_id;

        if($user_id===$penerima_id_on_disposisi){
            // update waktu_dibaca_disposisi on disposisi table
            Disposisi::where('form_tugas_id','=',$id)->update(['waktu_disposisi_dibaca'=>now(),'status'=>'1']);
        }
    }

    public function render()
    {
        return view('livewire.form-tugas.detail', [
            'formtugas' => FormTugas::find($this->form_tugas_id),
        ]);
    }
}

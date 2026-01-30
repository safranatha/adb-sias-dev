<?php

namespace App\Livewire\FormTugas;

use App\Helpers\DokumenTenderHelper;
use App\Models\Disposisi;
use App\Models\FormTugas;
use App\Models\User;
use Livewire\Component;
use App\Services\SendTelegram\Tender\FormTugas\UpdateStatusFormTugasTele;

class Detail extends Component
{
    public $form_tugas_id;

    public function mount($id)
    {
        $this->form_tugas_id = $id;
        $this->timestamp_baca($id);
    }

    public function boot(UpdateStatusFormTugasTele $updateStatusFormTugasTele)
    {
        $this->updateStatusFormTugasTele = $updateStatusFormTugasTele;
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

            $pengirim=FormTugas::where('id', '=', $id)->first()->user_id;

            $chat_id_pengirim=User::where('id', '=', $pengirim)->first()->telegram_chat_id;

            $jenis_permintaan=FormTugas::where('id', '=', $id)->first()->jenis_permintaan;

            $this->updateStatusFormTugasTele->sendMessageToPengirim($jenis_permintaan, $penerima_id_on_disposisi, $chat_id_pengirim,);
        }
    }

    public function render()
    {
        return view('livewire.form-tugas.detail', [
            'formtugas' => FormTugas::find($this->form_tugas_id),
        ])->title('Detail Form Tugas');
    }
}

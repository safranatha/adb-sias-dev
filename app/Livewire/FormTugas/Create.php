<?php

namespace App\Livewire\FormTugas;

use App\Helpers\DokumenTenderHelper;
use App\Models\Disposisi;
use App\Models\FormTugas;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\SendTelegram\Tender\FormTugas\CreateFormTugasTele;

class Create extends Component
{
    use WithFileUploads;
    public $user_id;
    public $due_date;
    public $jenis_permintaan;
    public $kegiatan;
    public $keterangan;
    public $file_path_form_tugas;
    public $lingkup_kerja;
    public $penerima;

    protected $rules = [
        'penerima' => 'required',
        'lingkup_kerja' => 'required',
        'due_date' => 'required|date',
        'jenis_permintaan' => 'required',
        'kegiatan' => 'required',
        'keterangan' => 'nullable',
        'file_path_form_tugas' => 'nullable',
    ];

    public function boot(CreateFormTugasTele $createFormTugasTele)
    {
        $this->createFormTugasTele = $createFormTugasTele;
    }

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->due_date = '';
        $this->lingkup_kerja = '';
        $this->jenis_permintaan = '';
        $this->kegiatan = '';
        $this->keterangan = '';
        $this->file_path_form_tugas = '';
    }

    public function store()
    {
        $this->validate();

        // store form tugas without file path
        $form_tugas = FormTugas::create([
            'user_id' => auth()->user()->id,
            'due_date' => $this->due_date,
            'lingkup_kerja' => $this->lingkup_kerja,
            'jenis_permintaan' => $this->jenis_permintaan,
            'kegiatan' => $this->kegiatan,
            'keterangan' => $this->keterangan,
        ]);

        // store to disposisi table
        Disposisi::create([
            'form_tugas_id' => $form_tugas->id,
            'penerima_id' => $this->penerima,
        ]);

        // pengecekan jika ada file path maka akan update di kolom form tugas yang telah distore
        if ($this->file_path_form_tugas) {
            $path = DokumenTenderHelper::storeFileOnStroage($this->file_path_form_tugas, 'form_tugas');

            // Save to database
            FormTugas::where('id', $form_tugas->id)->update([
                'file_path_form_tugas' => $path,
            ]);
        }

        $chat_id = User::where('id', $this->penerima)->first()->telegram_chat_id;

        // send telegram to penerima
        $this->createFormTugasTele
            ->sendMessageToPenerima(
                $this->jenis_permintaan,
                $this->kegiatan,
                $chat_id,
                $this->due_date,
            );

        session()->flash('success', 'Form tugas berhasil diupload!');

        return redirect()->route('form-tugas.index');
    }


    public function render()
    {
        return view('livewire.form-tugas.create', [
            'list_penerima_direktur' => User::role(['Manajer Admin', 'Manajer Teknik'])->get(),
            'list_penerima_manajer_teknik' => User::role('Staff Teknik')->get(),
            'list_penerima_manajer_admin' => User::role('Staff Admin')->get(),

        ])->title('Buat Form Tugas Baru');

    }
}

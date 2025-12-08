<?php

namespace App\Livewire\Tender;

use App\Models\Proposal;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use Livewire\Component;

class Detail extends Component
{

    public $tender_id; // wajib ada

    public function mount($id)
    {
        $this->tender_id = $id;
    }

    public function get_data_proposal($id)
    {
        $proposal = Proposal::where('tender_id', $id)->first();

        if ($proposal== null) {
            return session()->flash('error', 'Proposal tidak ditemukan.');
        }

        $file = public_path('storage/' . $proposal->file_path_proposal);

        if (!file_exists($file)) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'File tidak ditemukan di storage.'
            ]);
            return;
        }

        return response()->download($file);

    }


    public function get_data_SPH($id)
    {
        $sph = SuratPenawaranHarga::where('tender_id', $id)->first();

        if ($sph== null) {
            return session()->flash('error', 'Surat Penawaran Harga tidak ditemukan.');
        }

        $file = public_path('storage/' . $sph->file_path_sph);

        if (!file_exists($file)) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'File tidak ditemukan di storage.'
            ]);
            return;
        }

        return response()->download($file);

    }


    public function render()
    {
        // $proposal_id = Proposal::where('tender_id', $selected_tender_id)->pluck('id');
        return view('livewire.tender.detail', ['tender' => Tender::find($this->tender_id)]);
    }
}

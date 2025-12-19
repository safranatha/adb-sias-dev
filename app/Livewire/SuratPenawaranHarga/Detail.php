<?php

namespace App\Livewire\SuratPenawaranHarga;

use App\Models\DocumentApprovalWorkflow;
use Livewire\Component;

class Detail extends Component
{

    public $surat_penawaran_harga_id;

    public function mount($id)
    {
        $this->surat_penawaran_harga_id = $id;
    }

    public function render()
    {
        return view('livewire.surat-penawaran-harga.detail', [
            'document_approvals' => DocumentApprovalWorkflow::with(['surat_penawaran_harga'])
                ->where('surat_penawaran_harga_id', $this->surat_penawaran_harga_id)
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }
}

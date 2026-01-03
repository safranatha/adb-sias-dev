<?php

namespace App\Livewire\Dashboard;

use App\Helpers\DokumenChart;
use App\Models\DocumentApprovalWorkflow;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ChartProposal extends Component
{
    public function render()
    {
        $proposal_belum_disetujui_manajer = DokumenChart::dokumenBelumDisetujuiManajer('proposal_id');

        $proposal_ditolak_manajer =
            DokumenChart::dokumenDitolakManajer('proposal_id');

        $proposal_sudah_disetujui_manajer = DokumenChart::dokumenSudahDisetujuiManajer('proposal_id');

        $proposal_ditolak_direktur = DokumenChart::dokumenDitolakDirektur('proposal_id');

        $proposal_sudah_disetujui_direktur = DokumenChart::dokumenSudahDisetujuiDirektur('proposal_id');
            

        return view('livewire.dashboard.chart-proposal', [
            'labels' => ['Belum disetujui Manajer', 'Tolak manajer', 'Belum disetujui Direktur', 'Tolak direktur', 'Disetujui direktur'],
            'values' => [$proposal_belum_disetujui_manajer, $proposal_ditolak_manajer, $proposal_sudah_disetujui_manajer, $proposal_ditolak_direktur, $proposal_sudah_disetujui_direktur],
        ]);
    }
}

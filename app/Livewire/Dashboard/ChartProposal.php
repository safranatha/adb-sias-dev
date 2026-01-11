<?php

namespace App\Livewire\Dashboard;

use App\Services\Tender\DokumenChartService;
use App\Models\DocumentApprovalWorkflow;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ChartProposal extends Component
{
    protected DokumenChartService $dokumenChartService;

    public function boot(DokumenChartService $dokumenChartService)
    {
        $this->dokumenChartService = $dokumenChartService;
    }

    public function render()
    {
        $proposal_belum_disetujui_manajer =
            $this->dokumenChartService->dokumenBelumDisetujuiManajer('proposal_id');

        $proposal_ditolak_manajer =
            $this->dokumenChartService->dokumenDitolakManajer('proposal_id');

        $proposal_sudah_disetujui_manajer =
            $this->dokumenChartService->dokumenSudahDisetujuiManajer('proposal_id');

        $proposal_ditolak_direktur =
            $this->dokumenChartService->dokumenDitolakDirektur('proposal_id');

        $proposal_sudah_disetujui_direktur =
            $this->dokumenChartService->dokumenSudahDisetujuiDirektur('proposal_id');

        return view('livewire.dashboard.chart-proposal', [
            'labels' => [
                'Belum disetujui Manajer',
                'Tolak manajer',
                'Belum disetujui Direktur',
                'Tolak direktur',
                'Disetujui direktur'
            ],
            'values' => [
                $proposal_belum_disetujui_manajer,
                $proposal_ditolak_manajer,
                $proposal_sudah_disetujui_manajer,
                $proposal_ditolak_direktur,
                $proposal_sudah_disetujui_direktur
            ],
        ]);
    }
}

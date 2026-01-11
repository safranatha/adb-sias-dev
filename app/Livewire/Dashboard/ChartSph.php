<?php

namespace App\Livewire\Dashboard;

use App\Services\Tender\DokumenChartService;
use App\Models\DocumentApprovalWorkflow;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ChartSph extends Component
{
    protected DokumenChartService $dokumenChartService;

    public function boot(DokumenChartService $dokumenChartService)
    {
        $this->dokumenChartService = $dokumenChartService;
    }

    public function render()
    {
        $sph_belum_disetujui_manajer = $this->dokumenChartService->dokumenBelumDisetujuiManajer('surat_penawaran_harga_id');

        $sph_ditolak_manajer =
            $this->dokumenChartService->dokumenDitolakManajer('surat_penawaran_harga_id');

        $sph_sudah_disetujui_manajer =
            $this->dokumenChartService->dokumenSudahDisetujuiManajer('surat_penawaran_harga_id');

        $sph_ditolak_direktur = $this->dokumenChartService->dokumenDitolakDirektur('surat_penawaran_harga_id');

        $sph_sudah_disetujui_direktur = $this->dokumenChartService->dokumenSudahDisetujuiDirektur('surat_penawaran_harga_id');

        return view('livewire.dashboard.chart-sph', [
            'labels' => ['Belum disetujui Manajer', 'Tolak manajer', 'Belum disetujui Direktur', 'Tolak direktur', 'Disetujui direktur'],
            'values' => [$sph_belum_disetujui_manajer, $sph_ditolak_manajer, $sph_sudah_disetujui_manajer, $sph_ditolak_direktur, $sph_sudah_disetujui_direktur],
        ]);
    }
}

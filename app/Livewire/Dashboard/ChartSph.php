<?php

namespace App\Livewire\Dashboard;

use App\Helpers\DokumenChart;
use App\Models\DocumentApprovalWorkflow;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ChartSph extends Component
{
    public function render()
    {
        $sph_belum_disetujui_manajer = DokumenChart::dokumenBelumDisetujuiManajer('surat_penawaran_harga_id');

        $sph_ditolak_manajer =
            DokumenChart::dokumenDitolakManajer('surat_penawaran_harga_id');

        $sph_sudah_disetujui_manajer =
            DokumenChart::dokumenSudahDisetujuiManajer('surat_penawaran_harga_id');

        $sph_ditolak_direktur = DokumenChart::dokumenDitolakDirektur('surat_penawaran_harga_id');

        $sph_sudah_disetujui_direktur = DokumenChart::dokumenSudahDisetujuiDirektur('surat_penawaran_harga_id');

        return view('livewire.dashboard.chart-sph', [
            'labels' => ['Belum disetujui Manajer', 'Tolak manajer', 'Belum disetujui Direktur', 'Tolak direktur', 'Disetujui direktur'],
            'values' => [$sph_belum_disetujui_manajer, $sph_ditolak_manajer, $sph_sudah_disetujui_manajer, $sph_ditolak_direktur, $sph_sudah_disetujui_direktur],
        ]);
    }
}

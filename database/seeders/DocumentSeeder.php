<?php

namespace Database\Seeders;

use App\Models\Disposisi;
use App\Models\DocumentApprovalWorkflow;
use App\Models\FormTugas;
use App\Models\Proposal;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tender::factory(10)->create();
        // SuratPenawaranHarga::factory(10)->create();
        // Proposal::factory(10)->create();
        // DocumentApprovalWorkflow::factory(5)->create();
        // FormTugas::factory(10)->create();
        Disposisi::factory(10)->create();
    }
}

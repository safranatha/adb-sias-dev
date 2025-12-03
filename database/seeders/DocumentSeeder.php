<?php

namespace Database\Seeders;

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
        Tender::factory(10)->create();
        SuratPenawaranHarga::factory(10)->create();
        Proposal::factory(10)->create();
    }
}

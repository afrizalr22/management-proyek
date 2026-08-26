<?php

namespace App\Livewire\Mandor\DailyReports;

use Livewire\Component;

class Edit extends Component
{
    public int $reportId;

    /*
    |--------------------------------------------------------------------------
    | Data laporan
    |--------------------------------------------------------------------------
    */

    public string $projectName = 'Pembangunan Gedung Perkantoran Sudirman';
    public string $reportDate = '2026-08-25';
    public string $activities = '';
    public string $obstacles = '';
    public string $notes = '';

    public function mount(int $report): void
    {
        $this->reportId = $report;

        /*
         * Sementara masih menggunakan data UI.
         * Pengambilan data dari database akan dibuat pada tahap integrasi.
         */
        $this->activities = 'Pengecoran kolom lantai dua zona A telah diselesaikan.';
        $this->obstacles = 'Pengiriman material mengalami keterlambatan.';
        $this->notes = 'Persiapan pekerjaan berikutnya dilakukan di zona B.';
    }

    public function updateReport(): void
    {
        /*
         * Proses validasi dan penyimpanan ke database
         * akan dibuat pada tahap integrasi database.
         */
    }

    public function render()
    {
        return view('livewire.mandor.daily-reports.edit');
    }
}
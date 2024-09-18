<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnalisaGAPExport implements FromCollection, WithHeadings
{
    protected $analisaGaps;

    public function __construct($analisaGaps)
    {
        $this->analisaGaps = $analisaGaps;
    }

    public function collection()
    {
        return collect($this->analisaGaps)->map(function ($gap) {
            return [
                'jabatan' => is_array($gap) && isset($gap['jabatan']) ? $gap['jabatan'] : 'N/A',
                'nip' => is_array($gap) && isset($gap['nip']) ? $gap['nip'] : 'N/A',
                'pemangku_jabatan' => is_array($gap) && isset($gap['pemangku_jabatan']) ? $gap['pemangku_jabatan'] : 'N/A',
                'nilai_kompetensi' => is_array($gap) && isset($gap['nilai_kompetensi']) ? $gap['nilai_kompetensi'] : 0,
                'nilai_standar_kompetensi' => is_array($gap) && isset($gap['nilai_standar_kompetensi']) ? $gap['nilai_standar_kompetensi'] : 0,
            ];
        });
    }
    

    public function headings(): array
    {
        return [
            'Nama Jabatan',
            'NIP',
            'Pemangku Jabatan',
            'Nilai Kompetensi',
            'Nilai Standar Kompetensi'
        ];
    }
}

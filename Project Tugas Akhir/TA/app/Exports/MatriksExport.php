<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MatriksExport implements FromCollection, WithHeadings, WithStyles, WithEvents, WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item, $index) {
            $syaratJabatan = '';
            $namaJabatan = '';

            if ($item instanceof \App\Models\Dosen) {
                $namaJabatan = 'Dosen';
                $syaratJabatan = "1. Pendidikan: S2, Teknik Elektro\n";
                $syaratJabatan .= "2. Pelatihan:\n";
                $syaratJabatan .= "- Pengembangan SDM\n";
                $syaratJabatan .= "- Bidang Terkait\n";
                $syaratJabatan .= "3. Keterampilan/Pengalaman:\n";
                $syaratJabatan .= "GOL minimal III B\n";
                $syaratJabatan .= "PANGKAT min Penata Muda TK I\n";
                $syaratJabatan .= "UMUR minimal 24 Tahun\n";

                // Menambahkan detail mata kuliah
                $mataKuliahDetails = "MK.\n";
                foreach ($item->mataKuliahDosen as $mk) {
                    $mataKuliahDetails .= "- " . $mk->mata_kuliah . "\n";
                }
                $namaJabatan .= "\n" . $mataKuliahDetails;
            } else {
                $namaJabatan = $item->jabatan;
                if ($item->jabatan == 'Ketua Jurusan') {
                    $syaratJabatan = "1. Pendidikan: S1\n";
                    $syaratJabatan .= "2. Pelatihan:\n";
                    $syaratJabatan .= "- Bidang terkait\n";
                    $syaratJabatan .= "3. Keterampilan/Pengalaman:\n";
                    $syaratJabatan .= "- Penata / III C\n";
                    $syaratJabatan .= "- Usia 32 tahun\n";
                    $syaratJabatan .= "- Dosen selama 6 tahun\n";
                } elseif ($item->jabatan == 'Koordinator Program Studi') {
                    $syaratJabatan = "1. Pendidikan: S1\n";
                    $syaratJabatan .= "2. Pelatihan:\n";
                    $syaratJabatan .= "- Bidang terkait\n";
                    $syaratJabatan .= "3. Keterampilan/Pengalaman:\n";
                    $syaratJabatan .= "- Penata Muda Tk. I/ III B\n";
                    $syaratJabatan .= "- Usia 30 tahun\n";
                    $syaratJabatan .= "- Dosen selama 4 Tahun\n";
                } elseif ($item->jabatan == 'Sekretaris Jurusan') {
                    $syaratJabatan = "1. Pendidikan: S1\n";
                    $syaratJabatan .= "2. Pelatihan:\n";
                    $syaratJabatan .= "- Bidang terkait\n";
                    $syaratJabatan .= "3. Keterampilan/Pengalaman:\n";
                    $syaratJabatan .= "- Penata Muda Tk. I/ III B\n";
                    $syaratJabatan .= "- Usia 31 tahun\n";
                    $syaratJabatan .= "- Dosen selama 5 Tahun\n";
                } elseif ($item->jabatan == 'Kepala Laboratorium Teknik Informatika') {
                    $syaratJabatan = "1. Pendidikan: S1\n";
                    $syaratJabatan .= "2. Pelatihan:\n";
                    $syaratJabatan .= "- Bidang terkait\n";
                    $syaratJabatan .= "3. Keterampilan/Pengalaman:\n";
                    $syaratJabatan .= "- Penata Muda Tk. I/ III B\n";
                    $syaratJabatan .= "- Usia 30 tahun\n";
                    $syaratJabatan .= "- Di laboratorium 4 Tahun\n";
                } elseif ($item->jabatan == 'Teknisi Laboratorium Informatika') {
                    $syaratJabatan = "1. Pendidikan: D3 Teknik Informatika\n";
                    $syaratJabatan .= "2. Pelatihan:\n";
                    $syaratJabatan .= "- Pelatihan Teknisi\n";
                    $syaratJabatan .= "3. Keterampilan/Pengalaman:\n";
                    $syaratJabatan .= "- Pengatur/ II C\n";
                    $syaratJabatan .= "- Usia 21 tahun\n";
                    $syaratJabatan .= "- Di laboratorium min 3 Tahun\n";
                } elseif ($item->jabatan == 'Staf Administrasi Prodi') {
                    $syaratJabatan = "1. Pendidikan: D3 Administrasi\n";
                    $syaratJabatan .= "2. Pelatihan:\n";
                    $syaratJabatan .= "- Bidang terkait (kearsipan, dll)\n";
                    $syaratJabatan .= "3. Keterampilan/Pengalaman:\n";
                    $syaratJabatan .= "- Pengatur/ II C\n";
                    $syaratJabatan .= "- Usia 21 tahun\n";
                    $syaratJabatan .= "- Di administrasi min 3 Tahun\n";
                } else {
                    $syaratJabatan = "1. Pendidikan: Sesuai jabatan\n";
                    $syaratJabatan .= "2. Pelatihan:\n";
                    $syaratJabatan .= "- Sesuai jabatan\n";
                    $syaratJabatan .= "3. Keterampilan/Pengalaman:\n";
                    $syaratJabatan .= "Sesuai jabatan\n";
                }
            }

            // Menggabungkan Kompetensi (Curriculum Vitae)
            // Riwayat Pendidikan
            $riwayatPendidikan = '';
            if ($item->riwayatPendidikan && $item->riwayatPendidikan->count() > 0) {
                foreach ($item->riwayatPendidikan as $rp) {
                    $riwayatPendidikan .= "- " . $rp->riwayat_pendidikan . "\n";
                }
            } else {
                $riwayatPendidikan = "-\n";
            }

            $pelatihan = '';
            if ($item->pelatihan && $item->pelatihan->count() > 0) {
                foreach ($item->pelatihan as $p) {
                    $pelatihan .= "- " . $p->nama_pelatihan . "\n";
                }
            } else {
                $pelatihan = "-\n";
            }

            $keterampilan = '';
            if ($item->keterampilan && $item->keterampilan->count() > 0) {
                foreach ($item->keterampilan as $k) {
                    $keterampilan .= "- Golongan: " . $k->golongan . "\n";
                    $keterampilan .= "  Pangkat: " . $k->pangkat . "\n";
                    $keterampilan .= "  Umur: " . $k->umur . " Tahun\n";
                }
            } else {
                $keterampilan = "-\n";
            }


            // Membuat string untuk Kompetensi (Curriculum Vitae)
            $kompetensiCV = "1. Pendidikan:\n" . $riwayatPendidikan;
            $kompetensiCV .= "2. Pelatihan:\n" . $pelatihan;
            $kompetensiCV .= "3. Keterampilan/Pengalaman:\n" . $keterampilan;

            return [
                $index + 1,
                $namaJabatan,
                $syaratJabatan,
                $item->nip,
                $item->user->name ?? '-',
                $kompetensiCV, // Menambahkan kolom Kompetensi (Curriculum Vitae)
                isset($item->nilai) ? $item->nilai->nilai ?? '-' : '-', // Nilai
                isset($item->nilai) ? $item->nilai->Pro_Act ?? '-' : '-', // Pro_Act
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Jabatan',
            'Syarat Jabatan',
            'NIP',
            'Pemangku Jabatan',
            'Kompetensi (Curriculum Vitae)',
            'Nilai',
            'Pro_Act',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling header
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F2F2F2'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'wrapText' => true, // Aktifkan pembungkusan teks
            ],
        ]);

        // Mengatur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(50); // Kompetensi (Curriculum Vitae)
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(10);

        // Set format untuk kolom NIP sebagai angka
        $sheet->getStyle('D')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

        // Aktifkan pembungkusan teks untuk kolom Kompetensi (Curriculum Vitae)
        $sheet->getStyle('F')->getAlignment()->setWrapText(true);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Terapkan border ke semua sel
                $sheet->getStyle('A1:H' . $sheet->getHighestRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        'wrapText' => true,
                    ],
                ]);

                // Mengatur tinggi baris otomatis agar sesuai dengan konten
                foreach (range(1, $sheet->getHighestRow()) as $row) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }

                // Menambahkan informasi tambahan di bagian bawah (jika diperlukan)
                // Contoh:
                /*
                $sheet->mergeCells('A' . ($sheet->getHighestRow() + 1) . ':H' . ($sheet->getHighestRow() + 1));
                $sheet->setCellValue('A' . ($sheet->getHighestRow()), 'Informasi tambahan di sini');
                */
            },
        ];
    }

    public function title(): string
    {
        return 'Matriks Kompetensi';
    }
}

<!DOCTYPE html>
<html>
<head>
    <title>Matriks Kompetensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .header h2, .header h4 {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
        }
        .title-cell {
            text-align: center;
            font-weight: bold;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
        }
        .right-align {
            text-align: right;
        }
        .tfoot-summary td {
            border-top: 2px solid black;
            font-weight: bold;
        }
        .format-penilaian {
            font-size: 0.75em; 
            margin-top: 20px;
            line-height: 1.5; 
        }

    </style>
</head>
<body>
    <div class="header">
        <!-- Gambar Logo Kiri -->
        <img src="{{ public_path('images/POLNEP.png') }}" style="width: 70px; height: 70px; float: left;" alt="Left Logo">
        
        <!-- Gambar Logo Kanan -->
        <img src="{{ public_path('images/logo.png') }}" style="width: 70px; height: 70px; float: right;" alt="Right Logo">


        <!-- Judul Header -->
        <h2>POLITEKNIK NEGERI PONTIANAK</h2>
        <h2>MATRIKS KOMPETENSI PEGAWAI</h2>
        <h4>JURUSAN TEKNIK ELEKTRO PROGRAM STUDI TEKNIK INFORMATIKA POLITEKNIK NEGERI PONTIANAK</h4>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jabatan</th>
                <th>Syarat Jabatan</th>
                <th>NIP</th>
                <th>Pemangku Jabatan</th>
                <th>Kompetensi (Curriculum Vitae)</th>
                <th>Nilai</th>
                <th>Pro_Act</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalKompetensi = 0;
                $jumlahData = count($data);
            @endphp
            @foreach ($data as $index => $item)
                @php
                    $riwayatPendidikan = $item->riwayatPendidikan ?? [];
                    $pelatihan = $item->pelatihan ?? [];
                    $keterampilan = $item->keterampilan ?? [];
                    $maxRows = max(count($riwayatPendidikan), count($pelatihan), count($keterampilan));
                    $totalKompetensi += $item->nilai->kompetensi ?? 0;
                @endphp
                <tr>
                    <td rowspan="{{ $maxRows + 7 }}">{{ $index + 1 }}</td>
                    <td rowspan="{{ $maxRows + 7 }}">
                        {{ $item instanceof \App\Models\Dosen ? 'Dosen' : $item->jabatan }} <br> 
                        @if($item instanceof \App\Models\Dosen)
                            MK. <br>
                            @foreach ($item->mataKuliahDosen as $mk)
                                - {{ $mk->mata_kuliah }} <br>
                            @endforeach
                        @endif
                    </td>
                    <td rowspan="{{ $maxRows + 7 }}">
                        @if($item instanceof \App\Models\Dosen)
                            <strong>1. Pendidikan:</strong> S2, Teknik Elektro <br>
                            <strong>2. Pelatihan:</strong> <br>
                            - Pengembangan SDM <br>
                            - Bidang Terkait <br>
                            <strong>3. Keterampilan/Pengalaman:</strong> <br>
                            GOL minimal III B <br>
                            PANGKAT min Penata Muda TK I <br>
                            UMUR minimal 24 Tahun <br>
                        @else
                            @if($item->jabatan == 'Ketua Jurusan')
                                <strong>1. Pendidikan:</strong> S1 <br>
                                <strong>2. Pelatihan:</strong> <br>
                                - Bidang terkait <br>
                                <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                - Penata / III C <br>
                                - Usia 32 tahun <br>
                                - Dosen selama 6 tahun <br>
                            @elseif($item->jabatan == 'Koordinator Program Studi')
                                <strong>1. Pendidikan:</strong> S1 <br>
                                <strong>2. Pelatihan:</strong> <br>
                                - Bidang terkait <br>
                                <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                - Penata Muda Tk. I/ III B <br>
                                - Usia 30 tahun <br>
                                - Dosen selama 4 Tahun <br>
                            @elseif($item->jabatan == 'Sekretaris Jurusan')
                                <strong>1. Pendidikan:</strong> S1 <br>
                                <strong>2. Pelatihan:</strong> <br>
                                - Bidang terkait <br>
                                <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                - Penata Muda Tk. I/ III B <br>
                                - Usia 31 tahun <br>
                                - Dosen selama 5 Tahun <br>
                            @elseif($item->jabatan == 'Kepala Laboratorium Teknik Informatika')
                                <strong>1. Pendidikan:</strong> S1 <br>
                                <strong>2. Pelatihan:</strong> <br>
                                - Bidang terkait <br>
                                <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                - Penata Muda Tk. I/ III B <br>
                                - Usia 30 tahun <br>
                                - Di laboratorium 4 Tahun <br>
                            @elseif($item->jabatan == 'Teknisi Laboratorium Informatika')
                                <strong>1. Pendidikan:</strong> D3 Teknik Informatika <br>
                                <strong>2. Pelatihan:</strong> <br>
                                - Pelatihan Teknisi <br>
                                <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                - Pengatur/ II C <br>
                                - Usia 21 tahun <br>
                                - Di laboratorium min 3 Tahun <br>
                            @elseif($item->jabatan == 'Staf Administrasi Prodi')
                                <strong>1. Pendidikan:</strong> D3 Administrasi <br>
                                <strong>2. Pelatihan:</strong> <br>
                                - Bidang terkait (kearsipan, dll) <br>
                                <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                - Pengatur/ II C <br>
                                - Usia 21 tahun <br>
                                - Di administrasi min 3 Tahun <br>
                            @else
                                <strong>1. Pendidikan:</strong> Sesuai jabatan <br>
                                <strong>2. Pelatihan:</strong> <br>
                                - Sesuai jabatan <br>
                                <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                Sesuai jabatan <br>
                            @endif
                        @endif
                    </td>
                    <td rowspan="{{ $maxRows + 7 }}">
                        {{ $item->nip }}
                    </td>
                    <td rowspan="{{ $maxRows + 7 }}">
                        {{ $item->user->name ?? '-' }}
                    </td>
                    <td><strong>1. Pendidikan:</strong></td>
                    <td class="text-center">
                        @if (isset($item->nilai) && isset($item->nilai->riwayat_pendidikan))
                            {{ $item->nilai->riwayat_pendidikan }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        {{ isset($item->nilai) ? $item->nilai->Pro_Act ?? '-' : '-' }}
                    </td>
                </tr>
                @foreach ($riwayatPendidikan as $education)
                    <tr>
                        <td>- {{ $education->riwayat_pendidikan }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>2. Pelatihan:</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($pelatihan as $training)
                    <tr>
                        <td>- {{ $training->nama_pelatihan }}</td>
                        <td class="text-center">
                            {{ isset($item->nilai) ? json_decode($item->nilai->pelatihan, true)[$training->id] ?? '-' : '-' }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>3. Keterampilan/Pengalaman:</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($keterampilan as $skill)
                    <tr>
                        <td>Gol {{ $skill->golongan }}</td>
                        <td class="text-center">
                            {{ isset($item->nilai) ? $item->nilai->golongan ?? '-' : '-' }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{ $skill->pangkat }}</td>
                        <td class="text-center">
                            {{ isset($item->nilai) ? $item->nilai->pangkat ?? '-' : '-' }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{ $skill->umur }} Tahun</td>
                        <td class="text-center">
                            {{ isset($item->nilai) ? $item->nilai->umur ?? '-' : '-' }}
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                <tr class="tfoot-summary">
                    <td colspan="6"><strong>Jumlah Nilai</strong></td>
                    <td class="text-center">{{ isset($item->nilai) ? $item->nilai->jumlah ?? '-' : '-' }}</td>
                    <td></td>
                </tr>
                <tr class="tfoot-summary">
                    <td colspan="6"><strong>Nilai Kompetensi</strong></td>
                    <td class="text-center">{{ isset($item->nilai) ? $item->nilai->kompetensi ?? '-' : '-' }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="tfoot-summary">
                <td colspan="6"><strong>Nilai Kompetensi Unit ({{ $jumlahData }} orang)</strong></td>
                <td class="text-center">{{ $totalKompetensi }}</td>
                <td></td>
            </tr>
            <tr class="tfoot-summary">
                <td colspan="6"><strong>Nilai Kompetensi Unit ({{ $jumlahData }} orang)</strong></td>
                <td class="text-center">{{ $jumlahData > 0 ? number_format($totalKompetensi / $jumlahData, 2) : '0.00' }}</td>
                <td></td>
            </tr>
                        <!-- Additional Information -->
<tr class="additional-info">
    <td colspan="8">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <strong>Terbitan:</strong> A
            </div>
            <div>
                <strong>Distribusi:</strong> WMM, BID. PROG. & EVALUASI, BID. PENYEL. & KERJASAMA
            </div>
        </div>
        <strong>Tgl. </strong> {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
        <br>
        <strong>Disahkan oleh Ketua Jurusan Teknik Elektro :</strong>
        <br><br><br><br><br><br>
        <div style="text-align: center;">
            Hasan, ST., MT.<br>
            NIP. 197108201999031003 <br><br><br>
            <strong>Revisi 1 : </strong> Tgl. {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}
        </div>
        <!-- revisi -->
    </td>
</tr>
</tfoot>
        </table>
            <div class="format-penilaian">
            <strong>Format Penilaian Kompetensi Jabatan sbb :</strong><br>
            Nilai 3 = Kompetensi lebih tinggi dari syarat jabatan<br>
            Nilai 2 = Kompetensi sama dengan syarat jabatan<br>
            Nilai 1 = Kompetensi lebih rendah dari syarat jabatan
        </div>
    </body>
</html>
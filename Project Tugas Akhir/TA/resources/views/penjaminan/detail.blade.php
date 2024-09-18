@extends('penjaminan.dashboard')

@section('content')
<div class="container mt-1">
    <h4 class="text-center mb-3">Detail Kompetensi</h4>
    <div class="mb-5">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Nama Jabatan</th>
                            <th class="text-center align-middle">Syarat Jabatan</th>
                            <th class="text-center align-middle">NIP</th>
                            <th class="text-center align-middle">Pemangku Jabatan</th>
                            <th class="text-center align-middle">Kompetensi (Curriculum Vitae)</th>
                            <th class="text-center align-middle">Nilai</th>
                            <th class="text-center align-middle">Pro_Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $riwayatPendidikan = $riwayatPendidikan ?? [];
                            $pelatihan = $pelatihan ?? [];
                            $keterampilan = $keterampilan ?? [];
                            $mataKuliah = $mataKuliah ?? [];
                        @endphp
                        <tr>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 9 }}">
                                {{ $entity instanceof \App\Models\Dosen ? 'Dosen' : $entity->jabatan }} <br> 
                                @if($entity instanceof \App\Models\Dosen)
                                    MK. <br>
                                    @foreach ($mataKuliah as $mk)
                                        - {{ $mk->mata_kuliah }} <br>
                                    @endforeach
                                @endif
                            </td>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 9 }}">
                                @if($entity instanceof \App\Models\Dosen)
                                    <strong>1. Pendidikan:</strong> S2, Teknik Elektro <br>
                                    <strong>2. Pelatihan:</strong> <br>
                                    - Pengembangan SDM <br>
                                    - Bidang Terkait <br>
                                    <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                    GOL minimal III B <br>
                                    PANGKAT min Penata Muda TK I <br>
                                    UMUR minimal 24 Tahun <br>
                                @else
                                    @if($entity->jabatan == 'Ketua Jurusan')
                                        <strong>1. Pendidikan:</strong> S1 <br>
                                        <strong>2. Pelatihan:</strong> <br>
                                        - Bidang terkait <br>
                                        <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                        - Penata / III C <br>
                                        - Usia 32 tahun <br>
                                        - Dosen selama 6 tahun <br>
                                    @elseif($entity->jabatan == 'Koordinator Program Studi')
                                        <strong>1. Pendidikan:</strong> S1 <br>
                                        <strong>2. Pelatihan:</strong> <br>
                                        - Bidang terkait <br>
                                        <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                        - Penata Muda Tk. I/ III B <br>
                                        - Usia 30 tahun <br>
                                        - Dosen selama 4 Tahun <br>
                                     @elseif($entity->jabatan == 'Sekretaris Jurusan')
                                        <strong>1. Pendidikan:</strong> S1 <br>
                                        <strong>2. Pelatihan:</strong> <br>
                                        - Bidang terkait <br>
                                        <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                        - Penata Muda Tk. I/ III B <br>
                                        - Usia 31 tahun <br>
                                        - Dosen selama 5 Tahun <br>
                                    @elseif($entity->jabatan == 'Kepala Laboratorium Teknik Informatika')
                                        <strong>1. Pendidikan:</strong> S1 <br>
                                        <strong>2. Pelatihan:</strong> <br>
                                        - Bidang terkait <br>
                                        <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                        - Penata Muda Tk. I/ III B <br>
                                        - Usia 30 tahun <br>
                                        - Di laboratorium 4 Tahun <br>
                                    @elseif($entity->jabatan == 'Teknisi Laboratorium Informatika')
                                        <strong>1. Pendidikan:</strong> D3 Teknik Informatika <br>
                                        <strong>2. Pelatihan:</strong> <br>
                                        - Pelatihan Teknisi <br>
                                        <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                        - Pengatur/ II C <br>
                                        - Usia 21 tahun <br>
                                        - Di laboratorium min 3 Tahun <br>
                                    @elseif($entity->jabatan == 'Staf Administrasi Prodi')
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
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 9 }}">
                                {{ $entity->nip }}
                            </td>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 9 }}">
                                {{ $user->name }}
                            </td>
                            <td><strong>1. Pendidikan:</strong></td>
                            <td class="text-center">
                                @if (isset($nilai) && isset($nilai->riwayat_pendidikan))
                                    {{ $nilai->riwayat_pendidikan }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                {{ isset($nilai) ? $nilai->Pro_Act ?? '-' : '-' }}
                            </td>
                        </tr>
                        @foreach ($riwayatPendidikan as $pendidikan)
                            <tr>
                                <td>- {{ $pendidikan->riwayat_pendidikan }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>2. Pelatihan:</strong></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php
                            $nilaiPelatihan = isset($nilai) ? json_decode($nilai->pelatihan, true) : [];
                        @endphp
                        @foreach ($pelatihan as $pel)
                            <tr>
                                <td>- {{ $pel->nama_pelatihan }}</td>
                                <td class="text-center">
                                    {{ $nilaiPelatihan[$pel->id] ?? '-' }}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>3. Keterampilan/Pengalaman:</strong></td>
                            <td></td>
                            <td></td>
                        @foreach ($keterampilan as $keter)
                            <tr>
                                <td>Gol {{ $keter->golongan }}</td>
                                <td class="text-center">
                                    {{ isset($nilai) ? $nilai->golongan ?? '-' : '-' }}
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{{ $keter->pangkat }}</td>
                                <td class="text-center">
                                    {{ isset($nilai) ? $nilai->pangkat ?? '-' : '-' }}
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{{ $keter->umur }} Tahun</td>
                                <td class="text-center">
                                    {{ isset($nilai) ? $nilai->umur ?? '-' : '-' }}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 2px solid black;">
                            <td colspan="5"><strong>Jumlah Nilai</strong></td>
                            <td class="text-center">{{ isset($nilai) ? $nilai->jumlah ?? '-' : '-' }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>Nilai Kompetensi</strong></td>
                            <td class="text-center">{{ isset($nilai) ? $nilai->kompetensi ?? '-' : '-' }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

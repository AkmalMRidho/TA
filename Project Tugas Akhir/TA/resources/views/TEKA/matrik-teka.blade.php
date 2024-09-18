@extends('TEKA.dashboard')

@section('content')
<div class="container mt-1">
    <h4 class="text-center mb-3">Matrik Kompetensi</h4>

    <div class="card mb-5">
        <div class="card-body">
            <div class="table-responsive">
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
                        <tr>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 8 }}">
                                {{ $tendik->jabatan }}
                            </td>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 8 }}">
                                @if($tendik->jabatan == 'Ketua Jurusan')
                                    <strong>1. Pendidikan:</strong> S1 <br>
                                    <strong>2. Pelatihan:</strong> <br>
                                    - Bidang terkait <br>
                                    <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                    - Penata / III C <br>
                                    - Usia 32 tahun <br>
                                    - Dosen selama 6 tahun <br>
                                @elseif($tendik->jabatan == 'Koordinator Program Studi')
                                    <strong>1. Pendidikan:</strong> S1 <br>
                                    <strong>2. Pelatihan:</strong> <br>
                                    - Bidang terkait <br>
                                    <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                    - Penata Muda Tk. I/ III B <br>
                                    - Usia 30 tahun <br>
                                    - Dosen selama 4 Tahun <br>
                                @elseif($tendik->jabatan == 'Sekretaris Jurusan')
                                    <strong>1. Pendidikan:</strong> S1 <br>
                                    <strong>2. Pelatihan:</strong> <br>
                                    - Bidang terkait <br>
                                    <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                    - Penata Muda Tk. I/ III B <br>
                                    - Usia 31 tahun <br>
                                    - Dosen selama 5 Tahun <br>
                                @elseif($tendik->jabatan == 'Kepala Laboratorium Teknik Informatika')
                                    <strong>1. Pendidikan:</strong> S1 <br>
                                    <strong>2. Pelatihan:</strong> <br>
                                    - Bidang terkait <br>
                                    <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                    - Penata Muda Tk. I/ III B <br>
                                    - Usia 30 tahun <br>
                                    - Di laboratorium 4 Tahun <br>
                                @elseif($tendik->jabatan == 'Teknisi Laboratorium Informatika')
                                    <strong>1. Pendidikan:</strong> D3 Teknik Informatika <br>
                                    <strong>2. Pelatihan:</strong> <br>
                                    - Pelatihan Teknisi <br>
                                    <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                    - Pengatur/ II C <br>
                                    - Usia 21 tahun <br>
                                    - Di laboratorium min 3 Tahun <br>
                                @elseif($tendik->jabatan == 'Staf Administrasi Prodi')
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
                            </td>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 8 }}">
                                {{ $tendik->nip }}
                            </td>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 8 }}">
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
                                @if (isset($nilai) && isset($nilai->Pro_Act))
                                    {{ $nilai->Pro_Act }}
                                @else
                                    -
                                @endif
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
                                <td class="text-center"></td> <!-- Tambahkan kolom kosong untuk pelatihan -->
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>3. Keterampilan/Pengalaman:</strong></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach ($keterampilan as $keter)
                            <tr>
                                <td>Gol {{ $keter->golongan }}</td>
                                <td class="text-center">
                                    {{ isset($nilai) ? $nilai->golongan ?? '-' : '-' }}
                                </td>
                                <td class="text-center"></td> <!-- Tambahkan kolom kosong untuk keterampilan -->
                            </tr>
                            <tr>
                                <td>{{ $keter->pangkat }}</td>
                                <td class="text-center">
                                    {{ isset($nilai) ? $nilai->pangkat ?? '-' : '-' }}
                                </td>
                                <td class="text-center"></td> <!-- Tambahkan kolom kosong untuk keterampilan -->
                            </tr>
                            <tr>
                                <td>Usia {{ $keter->umur }} Tahun</td>
                                <td class="text-center">
                                    {{ isset($nilai) ? $nilai->umur ?? '-' : '-' }}
                                </td>
                                <td class="text-center"></td> <!-- Tambahkan kolom kosong untuk keterampilan -->
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 2px solid black;">
                            <td colspan="5"><strong>Jumlah Nilai</strong></td>
                            <td class="text-center">{{ isset($nilai) ? $nilai->jumlah ?? '-' : '-' }}</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>Nilai Kompetensi</strong></td>
                            <td class="text-center">{{ isset($nilai) ? $nilai->kompetensi ?? '-' : '-' }}</td>
                            <td class="text-center"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="text-left mb-4">
        <button class="btn btn-danger" onclick="window.location.href='{{ route('dashboard.teka') }}'">Kembali</button>
        <button class="btn btn-primary" onclick="window.location.href='{{ route('formCV') }}'">Buat CV</button>
    </div>
</div>
@endsection

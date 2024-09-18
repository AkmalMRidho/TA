@extends('dosen.dashboard')

@section('content')
<div class="container mt-1">
    <h4 class="text-center mb-3"></h4>

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
                                Dosen <br> MK. <br>
                                @foreach ($mataKuliah as $mk)
                                    - {{ $mk->mata_kuliah }} <br>
                                @endforeach
                            </td>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 8 }}">
                                <strong>1. Pendidikan:</strong> S2, Teknik Elektro <br>
                                <strong>2. Pelatihan:</strong> <br>
                                - Pengembangan SDM <br>
                                - Bidang Terkait <br>
                                <strong>3. Keterampilan/Pengalaman:</strong> <br>
                                GOL minimal III B <br>
                                PANGKAT min Penata Muda TK I <br>
                                UMUR minimal 24 Tahun <br>
                            </td>
                            <td rowspan="{{ max(count($riwayatPendidikan), count($pelatihan), count($keterampilan)) + 8 }}">
                                {{ $dosen->nip }}
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
                                <td>Umur {{ $keter->umur }} Tahun</td>
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
        <button class="btn btn-danger" onclick="window.location.href='{{ route('dashboard.dosen') }}'">Kembali</button>
        <button class="btn btn-primary" onclick="window.location.href='{{ route('showCVForm-dosen') }}'">Buat CV</button>
    </div>
</div>
@endsection

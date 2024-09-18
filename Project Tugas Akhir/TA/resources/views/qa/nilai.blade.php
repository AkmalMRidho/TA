@extends('qa.dashboard')

@section('content')
<div class="container mt-1">
    <h4 class="text-center mb-4"> Nilai Kompetensi Untuk - {{ $dosen ? $dosen->user->name : $tendik->user->name }}</h4>

    <div class="card mb-5">
        <div class="card-body">
            @if ($dosen)
            <form action="{{ route('qa.nilai.store', $dosen->user_id) }}" method="POST">
            @elseif ($tendik)
            <form action="{{ route('qa.nilai.store', $tendik->user_id) }}" method="POST">
            @endif
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kompetensi</th>
                            <th>Data</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Riwayat Pendidikan</td>
                            <td>
                                @if ($dosen && $dosen->riwayatPendidikan->isNotEmpty())
                                    @foreach ($dosen->riwayatPendidikan as $pendidikan)
                                        - {{ $pendidikan->riwayat_pendidikan }}<br>
                                    @endforeach
                                @elseif ($tendik && $tendik->riwayatPendidikan->isNotEmpty())
                                    @foreach ($tendik->riwayatPendidikan as $pendidikan)
                                        - {{ $pendidikan->riwayat_pendidikan }}<br>
                                    @endforeach
                                @else
                                    Tidak ada data.
                                @endif
                                <td>
                                    <select class="form-control" name="riwayat_pendidikan" required>
                                        <option value="" disabled selected>Pilih Nilai</option>
                                        <option value="1" {{ (isset($dosenEvaluation) && $dosenEvaluation->riwayat_pendidikan == 1) || (isset($tendikEvaluation) && $tendikEvaluation->riwayat_pendidikan == 1) ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ (isset($dosenEvaluation) && $dosenEvaluation->riwayat_pendidikan == 2) || (isset($tendikEvaluation) && $tendikEvaluation->riwayat_pendidikan == 2) ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ (isset($dosenEvaluation) && $dosenEvaluation->riwayat_pendidikan == 3) || (isset($tendikEvaluation) && $tendikEvaluation->riwayat_pendidikan == 3) ? 'selected' : '' }}>3</option>
                                    </select>
                                </tr>
                        <tr>
                            <td>Pelatihan</td>
                            <td>
                                @if ($dosen && $dosen->pelatihan->isNotEmpty())
                                    @foreach ($dosen->pelatihan as $pelatihan)
                                        - {{ $pelatihan->nama_pelatihan }}<br>
                                    @endforeach
                                @elseif ($tendik && $tendik->pelatihan->isNotEmpty())
                                    @foreach ($tendik->pelatihan as $pelatihan)
                                        - {{ $pelatihan->nama_pelatihan }}<br>
                                    @endforeach
                                @else
                                    Tidak ada data.
                                @endif
                            </td>
                            <td>
                                @if (($dosen && $dosen->pelatihan->isNotEmpty()) || ($tendik && $tendik->pelatihan->isNotEmpty()))
                                    @foreach (($dosen ? $dosen->pelatihan : $tendik->pelatihan) as $pelatihan)
                                        <div class="input-group mb-2">
                                            @if ($pelatihan->sertifikat_path)
                                                <a href="{{ Storage::url($pelatihan->sertifikat_path) }}" target="_blank" class="input-group-text">{{ $pelatihan->nama_pelatihan }}</a>
                                            @else
                                                <span class="input-group-text">{{ $pelatihan->nama_pelatihan }}</span>
                                            @endif
                                            <select class="form-control" name="pelatihan[{{ $pelatihan->id }}]" required>
                                                <option value="" disabled selected>Pilih Nilai</option>   
                                                <option value="1" {{ isset($dosenEvaluation) && json_decode($dosenEvaluation->pelatihan, true)[$pelatihan->id] == 1 ? 'selected' : (isset($tendikEvaluation) && json_decode($tendikEvaluation->pelatihan, true)[$pelatihan->id] == 1 ? 'selected' : '') }}>1</option>
                                                <option value="2" {{ isset($dosenEvaluation) && json_decode($dosenEvaluation->pelatihan, true)[$pelatihan->id] == 2 ? 'selected' : (isset($tendikEvaluation) && json_decode($tendikEvaluation->pelatihan, true)[$pelatihan->id] == 2 ? 'selected' : '') }}>2</option>
                                                <option value="3" {{ isset($dosenEvaluation) && json_decode($dosenEvaluation->pelatihan, true)[$pelatihan->id] == 3 ? 'selected' : (isset($tendikEvaluation) && json_decode($tendikEvaluation->pelatihan, true)[$pelatihan->id] == 3 ? 'selected' : '') }}>3</option>
                                            </select>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Golongan</td>
                            <td>
                                @if ($dosen && $dosen->keterampilan->isNotEmpty())
                                    @foreach ($dosen->keterampilan as $keter)
                                        Gol {{ $keter->golongan }}<br>
                                    @endforeach
                                @elseif ($tendik && $tendik->keterampilan->isNotEmpty())
                                    @foreach ($tendik->keterampilan as $keter)
                                        Gol {{ $keter->golongan }}<br>
                                    @endforeach
                                @else
                                    Tidak ada data.
                                @endif
                                <td>
                                    <select class="form-control" name="golongan" required>
                                        <option value="" disabled selected>Pilih Nilai</option>
                                        <option value="1" {{ (isset($dosenEvaluation) && $dosenEvaluation->golongan == 1) || (isset($tendikEvaluation) && $tendikEvaluation->golongan == 1) ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ (isset($dosenEvaluation) && $dosenEvaluation->golongan == 2) || (isset($tendikEvaluation) && $tendikEvaluation->golongan == 2) ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ (isset($dosenEvaluation) && $dosenEvaluation->golongan == 3) || (isset($tendikEvaluation) && $tendikEvaluation->golongan == 3) ? 'selected' : '' }}>3</option>
                                    </select>
                                </tr>
                        <tr>
                            <td>Pangkat</td>
                            <td>
                                @if ($dosen && $dosen->keterampilan->isNotEmpty())
                                    @foreach ($dosen->keterampilan as $keter)
                                        {{ $keter->pangkat }}<br>
                                    @endforeach
                                @elseif ($tendik && $tendik->keterampilan->isNotEmpty())
                                    @foreach ($tendik->keterampilan as $keter)
                                        {{ $keter->pangkat }}<br>
                                    @endforeach
                                @else
                                    Tidak ada data.
                                @endif
                                <td>
                                    <select class="form-control" name="pangkat" required>
                                        <option value="" disabled selected>Pilih Nilai</option>
                                        <option value="1" {{ (isset($dosenEvaluation) && $dosenEvaluation->pangkat == 1) || (isset($tendikEvaluation) && $tendikEvaluation->pangkat == 1) ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ (isset($dosenEvaluation) && $dosenEvaluation->pangkat == 2) || (isset($tendikEvaluation) && $tendikEvaluation->pangkat == 2) ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ (isset($dosenEvaluation) && $dosenEvaluation->pangkat == 3) || (isset($tendikEvaluation) && $tendikEvaluation->pangkat == 3) ? 'selected' : '' }}>3</option>
                                    </select>
                                </tr>
                        <tr>
                            <td>Umur</td>
                            <td>
                                @if ($dosen && $dosen->keterampilan->isNotEmpty())
                                    @foreach ($dosen->keterampilan as $keter)
                                        {{ $keter->umur }} Tahun<br>
                                    @endforeach
                                @elseif ($tendik && $tendik->keterampilan->isNotEmpty())
                                    @foreach ($tendik->keterampilan as $keter)
                                        {{ $keter->umur }} Tahun<br>
                                    @endforeach
                                @else
                                    Tidak ada data.
                                @endif
                                <td>
                                    <select class="form-control" name="umur" required>
                                        <option value="" disabled selected>Pilih Nilai</option>
                                        <option value="1" {{ (isset($dosenEvaluation) && $dosenEvaluation->umur == 1) || (isset($tendikEvaluation) && $tendikEvaluation->umur == 1) ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ (isset($dosenEvaluation) && $dosenEvaluation->umur == 2) || (isset($tendikEvaluation) && $tendikEvaluation->umur == 2) ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ (isset($dosenEvaluation) && $dosenEvaluation->umur == 3) || (isset($tendikEvaluation) && $tendikEvaluation->umur == 3) ? 'selected' : '' }}>3</option>
                                    </select>
                                </tr>
                            <td>Pro_Act</td>
                            <td>
                                @if ($dosen && $dosenEvaluation && $dosenEvaluation->Pro_Act)
                                    {{ $dosenEvaluation->Pro_Act }}
                                @elseif ($tendik && $tendikEvaluation && $tendikEvaluation->Pro_Act)
                                    {{ $tendikEvaluation->Pro_Act }}
                                @else
                                    -
                                @endif
                            </td>
                            <td><input type="text" class="form-control" name="Pro_Act" value="{{ $dosenEvaluation->Pro_Act ?? $tendikEvaluation->Pro_Act ?? '' }}"></td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('qa.dashboard')

@section('content')
<div class="container mt-1">
    <h4 class="text-center mb-1">Analisa Gap Syarat Jabatan & Kompetensi</h4>

    <div class="d-flex justify-content-between mb-2">
        <form id="filter-form" class="form-inline">
            <select class="form-select w-auto" id="filter" name="filter" onchange="document.getElementById('filter-form').submit();">
                <option value="dosen" {{ $filter == 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="struktural" {{ $filter == 'struktural' ? 'selected' : '' }}>Struktural</option>
                <option value="teknisi-administrasi" {{ $filter == 'teknisi-administrasi' ? 'selected' : '' }}>Teknisi & Administrasi</option>
            </select>
        </form>
        <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#downloadModal">Download</button>
        </div>
    </div>

    <div class="card mb-5">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jabatan</th>
                        <th>NIP</th>
                        <th>Pemangku Jabatan</th>
                        <th>Nilai Kompetensi</th>
                        <th>Nilai Standar Kompetensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($analisaGaps as $index => $gap)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $gap['jabatan'] }}</td>
                            <td>{{ $gap['nip'] }}</td>
                            <td>{{ $gap['pemangku_jabatan'] }}</td>
                            <td>{{ number_format($gap['nilai_kompetensi'], 2) }}</td>
                            <td>{{ number_format($gap['nilai_standar_kompetensi'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Jumlah Nilai Kompetensi</td>
                        <td>{{ number_format($totalNilaiKompetensi, 2) }}</td>
                        <td>{{ number_format($totalNilaiStandarKompetensi, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4">Nilai Kompetensi / Nilai Standar Kompetensi x 100%</td>
                        <td colspan="2">{{ number_format($persentaseKompetensi, 2) }}%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">Download Analisa GAP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="download-form" action="{{ route('qa.download-analisa-pdf') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="matrix-type" class="form-label">Pilih Jenis Analisa GAP</label>
                        <select class="form-select" id="matrix-type" name="matrix_type">
                            <option value="dosen">Dosen</option>
                            <option value="struktural">Struktural</option>
                            <option value="teknisi-administrasi">Teknisi & Administrasi</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="download-form">Download PDF</button>
                <a href="{{ route('qa.download-analisa-excel') }}?matrix_type=dosen" class="btn btn-success">Download Excel</a>
            </div>
        </div>
    </div>
</div>
@endsection

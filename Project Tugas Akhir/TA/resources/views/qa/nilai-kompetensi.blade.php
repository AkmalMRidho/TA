@extends('qa.dashboard')

@section('content')
<div class="container mt-1">
    <h4 class="text-center mb-4">Nilai Kompetensi</h4>

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
            <a href="{{ route('qa.analisa-gap') }}" class="btn btn-secondary">Analisa Gap</a>
        </div>
    </div>

    <div class="card mb-5"> 
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Status Pengisian</th>
                        <th class="text-center">Status Nilai</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td class="text-center">{{ $index + 1 + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-center">
                                @if(($filter == 'dosen' && $user->dosen && $user->dosen->nip) || 
                                    ($filter == 'struktural' && $user->tendik && $user->tendik->nip) ||
                                    ($filter == 'teknisi-administrasi' && $user->tendik && $user->tendik->nip))
                                    ✔️
                                @else
                                    ✖️
                                @endif
                            </td>
                            <td class="text-center">
                                @if(($filter == 'dosen' && $user->dosen && $user->dosen->evaluations->isNotEmpty()) ||
                                    ($filter == 'struktural' && $user->tendik && $user->tendik->evaluations->isNotEmpty()) ||
                                    ($filter == 'teknisi-administrasi' && $user->tendik && $user->tendik->evaluations->isNotEmpty()))
                                    Sudah di Nilai
                                @else
                                    <strong>Belum di Nilai</strong>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($filter == 'dosen' && $user->dosen)
                                    <a href="{{ route('qa.nilai.create', $user->dosen->user_id) }}" class="btn btn-primary btn-sm">Beri Nilai</a>
                                    <a href="{{ route('qa.detail', $user->dosen->user_id) }}" class="btn btn-info btn-sm">Detail</a>
                                @elseif($filter == 'struktural' && $user->tendik)
                                    <a href="{{ route('qa.nilai.create', $user->tendik->user_id) }}" class="btn btn-primary btn-sm">Beri Nilai</a>
                                    <a href="{{ route('qa.detail', $user->tendik->user_id) }}" class="btn btn-info btn-sm">Detail</a>
                                @elseif($filter == 'teknisi-administrasi' && $user->tendik)
                                    <a href="{{ route('qa.nilai.create', $user->tendik->user_id) }}" class="btn btn-primary btn-sm">Beri Nilai</a>
                                    <a href="{{ route('qa.detail', $user->tendik->user_id) }}" class="btn btn-info btn-sm">Detail</a>
                                @else
                                    <span class="text-muted">Tidak ada data</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Link pagination -->
            <div class="d-flex justify-content-center">
                {{ $users->appends(['filter' => $filter])->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">Download Matriks Kompetensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="download-form" action="{{ route('qa.download-pdf') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="matrix-type" class="form-label">Pilih Jenis Matriks</label>
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
                <a href="{{ route('downloadExcel', ['matrix_type' => 'dosen']) }}" class="btn btn-success">Download Excel</a>
            </div>
        </div>
    </div>
</div>
@endsection

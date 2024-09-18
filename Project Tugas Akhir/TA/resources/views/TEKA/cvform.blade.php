@extends('TEKA.dashboard')

@section('content')
<div class="container mt-2 mb-5">
    <div class="card border-primary">
        <div class="card-header text-center bg-primary text-white">
            <h4>Pilih Data untuk CV Anda</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('generate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="checkbox" name="data[]" value="name" checked>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pelatihan" class="col-sm-3 col-form-label">Pelatihan</label>
                    <div class="col-sm-9">
                        <input type="checkbox" name="data[]" value="pelatihan">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="riwayatPendidikan" class="col-sm-3 col-form-label">Riwayat Pendidikan</label>
                    <div class="col-sm-9">
                        <input type="checkbox" name="data[]" value="riwayatPendidikan">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keterampilan" class="col-sm-3 col-form-label">Keterampilan</label>
                    <div class="col-sm-9">
                        <input type="checkbox" name="data[]" value="keterampilan">
                        <div class="ml-3 mt-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keterampilan[]" value="golongan" id="golongan">
                                <label class="form-check-label" for="golongan">Golongan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keterampilan[]" value="pangkat" id="pangkat">
                                <label class="form-check-label" for="pangkat">Pangkat</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keterampilan[]" value="umur" id="umur">
                                <label class="form-check-label" for="umur">Umur</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="keterampilan[]" value="lama_jabatan" id="lama_jabatan">
                                <label class="form-check-label" for="lama_jabatan">Lama Jabatan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="foto" class="col-sm-3 col-form-label">Foto</label>
                    <div class="col-sm-8">
                        <input type="file" name="foto" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="linkedin" class="col-sm-3 col-form-label">LinkedIn</label>
                    <div class="col-sm-4">
                        <input type="url" name="linkedin" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="github" class="col-sm-3 col-form-label">GitHub</label>
                    <div class="col-sm-4">
                        <input type="url" name="github" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary">Generate CV</button>
                        <button type="button" class="btn btn-danger" onclick="window.location.href='{{ url()->previous() }}'">Kembali</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

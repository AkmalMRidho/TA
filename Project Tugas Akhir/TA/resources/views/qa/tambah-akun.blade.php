@extends('qa.dashboard')

@section('content')
<div class="container mt-1 mb-5"> <!-- Menambahkan margin bottom pada container -->
    <h4 class="text-center mb-3">Tambah Akun</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('qa.store-akun') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="Dosen">Dosen</option>
                        <option value="Quality Assurance">Quality Assurance</option>
                        <option value="Ketua Jurusan">Ketua Jurusan</option>
                        <option value="Koordinator Program Studi">Koordinator Program Studi</option>
                        <option value="Sekretaris Jurusan">Sekretaris Jurusan</option>
                        <option value="Kalab TI">Kalab TI</option>
                        <option value="Teknisi Lab TI">Teknisi Lab TI</option>
                        <option value="Staf Administrasi Prodi">Staf Administrasi Prodi</option>
                        <option value="Penjaminan Mutu & Pengembangan Pembelajaran">Penjaminan Mutu & Pengembangan Pembelajaran</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('qa.manajemen-akun') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

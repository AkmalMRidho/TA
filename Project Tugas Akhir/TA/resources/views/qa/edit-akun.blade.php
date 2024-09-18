@extends('qa.dashboard')

@section('content')
<div class="container mt-1 mb-5"> <!-- Menambahkan margin bottom pada container -->
    <h4 class="text-center mb-3">Edit Akun</h4>
    <div class="card mb-5"> <!-- Menambahkan margin bottom pada card -->
        <div class="card-body">
            <form action="{{ route('qa.update-akun', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="Dosen" {{ $user->role == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="Quality Assurance" {{ $user->role == 'Quality Assurance' ? 'selected' : '' }}>Quality Assurance</option>
                        <option value="Ketua Jurusan" {{ $user->role == 'Ketua Jurusan' ? 'selected' : '' }}>Ketua Jurusan</option>
                        <option value="Koordinator Program Studi" {{ $user->role == 'Koordinator Program Studi' ? 'selected' : '' }}>Koordinator Program Studi</option>
                        <option value="Sekretaris Jurusan" {{ $user->role == 'Sekretaris Jurusan' ? 'selected' : '' }}>Sekretaris Jurusan</option>
                        <option value="Kalab TI" {{ $user->role == 'Kalab TI' ? 'selected' : '' }}>Kalab TI</option>
                        <option value="Teknisi Lab TI" {{ $user->role == 'Teknisi Lab TI' ? 'selected' : '' }}>Teknisi Lab TI</option>
                        <option value="Staf Administrasi Prodi" {{ $user->role == 'Staf Administrasi Prodi' ? 'selected' : '' }}>Staf Administrasi Prodi</option>
                        <option value="Penjaminan Mutu & Pengembangan Pembelajaran" {{ $user->role == 'Penjaminan Mutu & Pengembangan Pembelajaran' ? 'selected' : '' }}>Penjaminan Mutu & Pengembangan Pembelajaran</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('qa.manajemen-akun') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

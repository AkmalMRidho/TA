@extends('TEKA.dashboard')

@section('content')
<div class="container mt-2">
    <h4 class="text-center mb-4">Edit Kompetensi Tendik</h4>

    <form action="{{ route('lengkapi-kompetensi-teka.update', ['id' => $tendik->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group mb-4">
            <label for="nip" class="form-label">NIP:</label>
            <input type="text" id="nip" name="nip" class="form-control" value="{{ $tendik->nip }}" placeholder="NIP" required inputmode="numeric" pattern="[0-9]*">
        </div>

            <!-- Jabatan Section -->
            <div class="form-group mb-4">
                <label for="jabatan" class="form-label">Jabatan:</label>
                <select name="jabatan" class="form-control" required>
                    <option value="" disabled selected>Pilih Jabatan</option>
                    <option value="Ketua Jurusan" {{ $tendik->jabatan == 'Ketua Jurusan' ? 'selected' : '' }}>Ketua Jurusan</option>
                    <option value="Koordinator Program Studi" {{ $tendik->jabatan == 'Koordinator Program Studi' ? 'selected' : '' }}>Koordinator Program Studi</option>
                    <option value="Sekretaris Jurusan" {{ $tendik->jabatan == 'Sekretaris Jurusan' ? 'selected' : '' }}>Sekretaris Jurusan</option>
                    <option value="Kepala Laboratorium Teknik Informatika" {{ $tendik->jabatan == 'Kepala Laboratorium Teknik Informatika' ? 'selected' : '' }}>Kepala Laboratorium Teknik Informatika</option>
                    <option value="Teknisi Laboratorium Informatika" {{ $tendik->jabatan == 'Teknisi Laboratorium Informatika' ? 'selected' : '' }}>Teknisi Laboratorium Informatika</option>
                    <option value="Staf Administrasi Prodi" {{ $tendik->jabatan == 'Staf Administrasi Prodi' ? 'selected' : '' }}>Staf Administrasi Prodi</option>
                </select>
            </div>

            <!-- Pelatihan Section -->
            <div class="form-group mb-4">
                <label for="pelatihan" class="form-label">Pelatihan yang diikuti:</label>
                <button type="button" class="btn btn-sm btn-primary add-pelatihan mb-2">Tambah Pelatihan</button>
                <div id="pelatihan_wrapper">
                    @if ($tendik->pelatihan)
                        @foreach ($tendik->pelatihan as $pelatihan)
                        <div class="pelatihan_group mb-2">
                            <div class="input-group">
                                <input type="text" name="nama_pelatihan[]" class="form-control mb-2" value="{{ $pelatihan->nama_pelatihan }}" placeholder="Nama Pelatihan">
                                <input type="date" name="expired_sertifikat[]" class="form-control mb-2" value="{{ $pelatihan->expired_sertifikat }}">
                                <input type="file" name="sertifikat_path[]" class="form-control mb-2">
                                <button type="button" class="btn btn-danger remove-input">Hapus</button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="pelatihan_group mb-2">
                            <div class="input-group">
                                <input type="text" name="nama_pelatihan[]" class="form-control mb-2" placeholder="Nama Pelatihan">
                                <input type="date" name="expired_sertifikat[]" class="form-control mb-2">
                                <input type="file" name="sertifikat_path[]" class="form-control mb-2">
                                <button type="button" class="btn btn-danger remove-input">Hapus</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Pendidikan Section -->
            <div class="form-group mb-4">
                <label for="riwayat_pendidikan" class="form-label">Riwayat Pendidikan:</label>
                <button type="button" class="btn btn-sm btn-primary add-riwayat_pendidikan mb-2">Tambah Riwayat Pendidikan</button>
                <div id="riwayat_pendidikan_wrapper">
                    @if ($tendik->riwayatPendidikan)
                        @foreach ($tendik->riwayatPendidikan as $riwayat)
                        <div class="input-group mb-2 riwayat_pendidikan_group">
                            <input type="text" name="riwayat_pendidikan[]" class="form-control" value="{{ $riwayat->riwayat_pendidikan }}" placeholder="Riwayat Pendidikan" required>
                            <button type="button" class="btn btn-danger remove-input">Hapus</button>
                        </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2 riwayat_pendidikan_group">
                            <input type="text" name="riwayat_pendidikan[]" class="form-control" placeholder="Riwayat Pendidikan" required>
                            <button type="button" class="btn btn-danger remove-input">Hapus</button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="{{ $tendik->tanggal_lahir }}" required>
            </div>

            <!-- Keterampilan Section -->
            <div class="form-group mb-4">
    <label for="golongan" class="form-label">Keterampilan/Pengalaman:</label>
    <div class="row">
        <div class="col-md-4 mb-2">
            <select name="golongan" class="form-control" required>
                <option value="" disabled>Pilih Golongan</option>
                @foreach (['Honorer','I/a', 'I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'] as $golongan)
                    <option value="{{ $golongan }}"
                        @if ($tendik->keterampilan->contains('golongan', $golongan))
                            selected
                        @endif
                    >{{ $golongan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <select name="pangkat" class="form-control" required>
                <option value="" disabled>Pilih Pangkat</option>
                @foreach (['-','Juru Muda', 'Juru Muda Tingkat I', 'Juru', 'Juru Tingkat I', 'Pengatur Muda', 'Pengatur Muda Tingkat I', 'Pengatur', 'Pengatur Tingkat I', 'Penata Muda', 'Penata Muda Tingkat I', 'Penata', 'Penata Tingkat I', 'Pembina', 'Pembina Tingkat I', 'Pembina Utama Muda', 'Pembina Utama Madya', 'Pembina Utama'] as $pangkat)
                    <option value="{{ $pangkat }}"
                        @if ($tendik->keterampilan->contains('pangkat', $pangkat))
                            selected
                        @endif
                    >{{ $pangkat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <input type="number" name="umur" class="form-control" value="{{ $tendik->keterampilan->isNotEmpty() ? $tendik->keterampilan->first()->umur : '' }}" placeholder="Umur" required readonly>
        </div>
    </div>
</div>
            
            <div class="row mt-4 mb-5">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="reset" class="btn btn-secondary">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const tanggalLahirInput = document.getElementById('tanggal_lahir');
    const umurInput = document.querySelector('input[name="umur"]');

    function hitungUmur(tanggalLahir) {
        const today = new Date();
        const birthDate = new Date(tanggalLahir);
        let umur = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            umur--;
        }

        return umur;
    }

    // Update umur saat tanggal lahir diubah
    tanggalLahirInput.addEventListener('change', function () {
        const umur = hitungUmur(tanggalLahirInput.value);
        umurInput.value = umur;
    });

    // Set umur saat halaman pertama kali dimuat (jika tanggal lahir sudah ada)
    if (tanggalLahirInput.value) {
        const umur = hitungUmur(tanggalLahirInput.value);
        umurInput.value = umur;
    }
});
    document.getElementById('nip').addEventListener('input', function (e) {
        var value = e.target.value;

        // Cek apakah input hanya berisi angka
        if (!/^\d*$/.test(value)) {
            alert("NIP harus berupa angka!");
            e.target.value = value.replace(/\D/g, ''); // Hapus semua karakter non-angka
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        function updateRemoveButtons() {
            document.querySelectorAll('.remove-input').forEach(function (button) {
                button.addEventListener('click', function () {
                    button.closest('.input-group').remove();
                });
            });
        }

        document.querySelector('.add-pelatihan').addEventListener('click', function () {
            const wrapper = document.getElementById('pelatihan_wrapper');
            const newGroup = document.createElement('div');
            newGroup.className = 'pelatihan_group mb-2';

            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group';

            const newNamaPelatihan = document.createElement('input');
            newNamaPelatihan.type = 'text';
            newNamaPelatihan.name = 'nama_pelatihan[]';
            newNamaPelatihan.className = 'form-control mb-2';
            newNamaPelatihan.placeholder = 'Nama Pelatihan';
            newNamaPelatihan.required = true;

            const newExpiredSertifikat = document.createElement('input');
            newExpiredSertifikat.type = 'date';
            newExpiredSertifikat.name = 'expired_sertifikat[]';
            newExpiredSertifikat.className = 'form-control mb-2';
            newExpiredSertifikat.required = true;

            const newSertifikat = document.createElement('input');
            newSertifikat.type = 'file';
            newSertifikat.name = 'sertifikat_path[]';
            newSertifikat.className = 'form-control mb-2';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger remove-input';
            removeButton.textContent = 'Hapus';

            newInputGroup.appendChild(newNamaPelatihan);
            newInputGroup.appendChild(newExpiredSertifikat);
            newInputGroup.appendChild(newSertifikat);
            newInputGroup.appendChild(removeButton);

            newGroup.appendChild(newInputGroup);
            wrapper.appendChild(newGroup);

            updateRemoveButtons();
        });

        document.querySelector('.add-riwayat_pendidikan').addEventListener('click', function () {
            const wrapper = document.getElementById('riwayat_pendidikan_wrapper');
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2 riwayat_pendidikan_group';

            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.name = 'riwayat_pendidikan[]';
            newInput.className = 'form-control';
            newInput.placeholder = 'Riwayat Pendidikan';
            newInput.required = true;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger remove-input';
            removeButton.textContent = 'Hapus';

            newInputGroup.appendChild(newInput);
            newInputGroup.appendChild(removeButton);
            wrapper.appendChild(newInputGroup);

            updateRemoveButtons();
        });

        document.addEventListener('click', function (event) {
            if (event.target.matches('.remove-input')) {
                event.target.closest('.input-group').remove();
            }
        });

        updateRemoveButtons();
    });
</script>
@endsection

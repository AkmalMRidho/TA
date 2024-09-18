@extends('kokape.dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="text-center mb-4">Pendataan Matriks Kompetensi</h4>
    <form action="{{ route('lengkapi-kompetensi-kokape.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
	<div id="dynamic_form">
        <div class="form-group mb-4">
            <label for="nip" class="form-label">NIP:</label>
            <input type="text" name="nip" class="form-control" placeholder="NIP">
        </div>

        <div class="form-group mb-4">
            <label for="jabatan" class="form-label">Jabatan :</label>
            <select name="jabatan" class="form-control" required>
                <option value="" disabled selected>Pilih Jabatan</option>
                <option value="Ketua Jurusan">Ketua Jurusan</option>
                <option value="Koordinator Program Studi">Koordinator Program Studi</option>
                <option value="Sekretaris Jurusan">Sekretaris Jurusan</option>
                <option value="Kepala Laboratorium Teknik Informatika">Kepala Laboratorium Teknik Informatika</option>
            </select>
        </div>

        <div class="form-group mb-4">
            <label for="pelatihan" class="form-label">Pelatihan yang diikuti:</label>
            <button type="button" class="btn btn-sm btn-primary add-pelatihan mb-2">Tambah Pelatihan</button>
            <div id="pelatihan_wrapper">
                <div class="pelatihan_group mb-2">
                    <div class="input-group">
                        <input type="text" name="nama_pelatihan[]" class="form-control mb-2" placeholder="Nama Pelatihan" required>
                        <input type="date" name="expired_sertifikat[]" class="form-control mb-2" required>
                        <input type="file" name="sertifikat[]" class="form-control mb-2" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="riwayat_pendidikan" class="form-label">Riwayat Pendidikan:</label>
            <button type="button" class="btn btn-sm btn-primary add-riwayat_pendidikan mb-2">Tambah Riwayat Pendidikan</button>
            <div id="riwayat_pendidikan_wrapper">
                <div class="input-group mb-2 riwayat_pendidikan_group">
                    <input type="text" name="riwayat_pendidikan[]" class="form-control" placeholder="Riwayat Pendidikan" required>
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required>
        </div>
        
        <div class="form-group mb-4">
            <label for="golongan" class="form-label">Keterampilan/Pengalaman:</label>
            <div class="row">
                <div class="col-md-4 mb-2">
                   <select name="golongan" class="form-control" required>
                            <option value="" disabled selected>Pilih Golongan</option>
                            <option value="I/a">I/a</option>
                            <option value="I/b">I/b</option>
                            <option value="I/c">I/c</option>
                            <option value="I/d">I/d</option>
                            <option value="II/a">II/a</option>
                            <option value="II/b">II/b</option>
                            <option value="II/c">II/c</option>
                            <option value="II/d">II/d</option>
                            <option value="III/a">III/a</option>
                            <option value="III/b">III/b</option>
                            <option value="III/c">III/c</option>
                            <option value="III/d">III/d</option>
                            <option value="IV/a">IV/a</option>
                            <option value="IV/b">IV/b</option>
                            <option value="IV/c">IV/c</option>
                            <option value="IV/d">IV/d</option>
                            <option value="IV/e">IV/e</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <select name="pangkat" class="form-control" required>
                            <option value="" disabled selected>Pilih Pangkat</option>
                            <option value="Juru Muda">Juru Muda</option>
                            <option value="Juru Muda Tingkat I">Juru Muda Tingkat I</option>
                            <option value="Juru">Juru</option>
                            <option value="Juru Tingkat I">Juru Tingkat I</option>
                            <option value="Pengatur Muda">Pengatur Muda</option>
                            <option value="Pengatur Muda Tingkat I">Pengatur Muda Tingkat I</option>
                            <option value="Pengatur">Pengatur</option>
                            <option value="Pengatur Tingkat I">Pengatur Tingkat I</option>
                            <option value="Penata Muda">Penata Muda</option>
                            <option value="Penata Muda Tingkat I">Penata Muda Tingkat I</option>
                            <option value="Penata">Penata</option>
                            <option value="Penata Tingkat I">Penata Tingkat I</option>
                            <option value="Pembina">Pembina</option>
                            <option value="Pembina Tingkat I">Pembina Tingkat I</option>
                            <option value="Pembina Utama Muda">Pembina Utama Muda</option>
                            <option value="Pembina Utama Madya">Pembina Utama Madya</option>
                            <option value="Pembina Utama">Pembina Utama</option>
                        </select>
                </div>
                <div class="col-md-4 mb-2">
                    <input type="number" id="umur" name="umur" class="form-control" placeholder="Umur" required readonly>
                </div>
                <div class="form-group mb-4">
                    <label for="lama_jabatan" class="form-label">Lama Menjabat :</label>
                    <select name="lama_jabatan" class="form-control" required>
                        <option value="" disabled selected>Piih lamanya menjabat</option>
                        @for ($i = 1; $i <= 30; $i++)
                            <option value="Dosen selama {{ $i }} tahun">Dosen selama {{ $i }} tahun</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
	</div>
        <div class="row mt-4 mb-5">
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="reset" class="btn btn-secondary">Batal</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const tanggalLahirInput = document.getElementById('tanggal_lahir');
    const umurInput = document.getElementById('umur');

    // Fungsi untuk menghitung umur
    function hitungUmur(tanggalLahir) {
        const today = new Date();
        const birthDate = new Date(tanggalLahir);
        let umur = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        // Jika bulan saat ini lebih kecil dari bulan lahir, atau bulan sama tapi hari saat ini lebih kecil, kurangi umur
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            umur--;
        }
        return umur;
    }

    // Tambahkan event listener untuk mengupdate umur saat tanggal lahir diubah
    tanggalLahirInput.addEventListener('change', function () {
        const tanggalLahir = tanggalLahirInput.value;
        if (tanggalLahir) {
            const umur = hitungUmur(tanggalLahir);
            umurInput.value = umur;  // Update field umur
        }
    });
});
    document.addEventListener('DOMContentLoaded', function () {
        function updateRemoveButtons() {
            document.querySelectorAll('#pelatihan_wrapper .remove-input').forEach(button => {
                button.style.display = (document.querySelectorAll('#pelatihan_wrapper .pelatihan_group').length > 1) ? 'inline' : 'none';
            });
            document.querySelectorAll('#riwayat_pendidikan_wrapper .remove-input').forEach(button => {
                button.style.display = (document.querySelectorAll('#riwayat_pendidikan_wrapper .input-group').length > 1) ? 'inline' : 'none';
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
            newSertifikat.name = 'sertifikat[]';
            newSertifikat.className = 'form-control mb-2';
            newSertifikat.required = true;

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

        document.getElementById('dynamic_form').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-input')) {
                e.target.parentElement.remove();
                updateRemoveButtons();
            }
        });

        // Initial call to hide remove buttons if there's only one input group
        updateRemoveButtons();
    });
</script>
@endsection
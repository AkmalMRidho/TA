<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }
        .profile-pic {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-pic img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-size: 22px;
        }
        .section ul {
            list-style-type: none;
            padding: 0;
        }
        .section ul li {
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }
        .contact-info {
            text-align: center;
            margin-top: 20px;
        }
        .contact-info p {
            margin: 5px 0;
        }
        .contact-info a {
            color: #1a0dab;
            text-decoration: none;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Curriculum Vitae</h1>
        </div>

        <div class="profile-pic">
            @if($foto)
                <img src="{{ $foto->getRealPath() }}" alt="Foto Profil">
            @else
                <img src="{{ asset('images/default-profile.jpg') }}" alt="Foto Profil">
            @endif
        </div>

        @if(in_array('name', $data))
            <div class="section">
                <h2>Data Pribadi</h2>
                <ul>
                    <li><strong>Nama:</strong> {{ $user->name }}</li>
                    <li><strong>Email:</strong> {{ $user->email }}</li>
                </ul>
            </div>
        @endif

        @if(in_array('pelatihan', $data) && $tendik->pelatihan->count())
            <div class="section">
                <h2>Pelatihan</h2>
                <ul>
                    @foreach($tendik->pelatihan as $pelatihan)
                        <li>
                            {{ $pelatihan->nama_pelatihan }} - 
                            {{ $pelatihan->expired_sertifikat }}
                            @if($pelatihan->sertifikat_path)
                                (Sertifikat: <a href="{{ Storage::url($pelatihan->sertifikat_path) }}" target="_blank">Lihat</a>)
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(in_array('riwayatPendidikan', $data) && $tendik->riwayatPendidikan->count())
            <div class="section">
                <h2>Riwayat Pendidikan</h2>
                <ul>
                    @foreach($tendik->riwayatPendidikan as $pendidikan)
                        <li>{{ $pendidikan->riwayat_pendidikan }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(in_array('keterampilan', $data) && $tendik->keterampilan->count())
            @php
                $keterampilanData = $tendik->keterampilan->first();
            @endphp
            @if($keterampilanData)
                <div class="section">
                    <h2>Lainnya</h2>
                    <ul>
                        @if(in_array('golongan', $keterampilan))
                            <li>Golongan: {{ $keterampilanData->golongan }}</li>
                        @endif
                        @if(in_array('pangkat', $keterampilan))
                            <li>Pangkat: {{ $keterampilanData->pangkat }}</li>
                        @endif
                        @if(in_array('umur', $keterampilan))
                            <li>Umur: {{ $keterampilanData->umur }}</li>
                        @endif
                        @if(in_array('lama_jabatan', $keterampilan))
                            <li>Lama Jabatan: {{ $keterampilanData->lama_jabatan }}</li>
                        @endif
                    </ul>
                </div>
            @endif
        @endif

        <div class="contact-info">
            @if($linkedin)
                <p>LinkedIn: <a href="{{ $linkedin }}" target="_blank">{{ $linkedin }}</a></p>
            @endif

            @if($github)
                <p>GitHub: <a href="{{ $github }}" target="_blank">{{ $github }}</a></p>
            @endif
        </div>
    </div>
</body>
</html>

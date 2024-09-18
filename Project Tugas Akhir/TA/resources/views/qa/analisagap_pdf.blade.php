<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Analisa GAP Matriks Kompetensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .header h2, .header h4 {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Gambar Logo Kiri -->
        <img src="{{ public_path('images/POLNEP.png') }}" style="width: 70px; height: 70px; float: left;" alt="Left Logo">
        
        <!-- Gambar Logo Kanan -->
        <img src="{{ public_path('images/logo.png') }}" style="width: 70px; height: 70px; float: right;" alt="Right Logo">


        <!-- Judul Header -->
        <h2>POLITEKNIK NEGERI PONTIANAK</h2>
        <h2>MATRIKS KOMPETENSI PEGAWAI</h2>
        <h4>JURUSAN TEKNIK ELEKTRO PROGRAM STUDI TEKNIK INFORMATIKA POLITEKNIK NEGERI PONTIANAK</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jabatan</th>
                <th>NIP</th>
                <th>Pemangku Jabatan</th>
                <th>Nilai Kompetensi</th>
                <th>Nilai Standar Kom</th>
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
            <tr>
                <td colspan="4"><strong>JUMLAH NILAI KOMPETENSI</strong></td>
                <td><strong>{{ number_format($totalNilaiKompetensi, 2) }}</strong></td>
                <td><strong>{{ number_format($totalNilaiStandarKompetensi, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Analisa Gap Syarat Jabatan & Kompetensi =</p>
        <p>Nilai Kompetensi / Nilai Standar Kompetensi × 100% =</p>
        <p>{{ number_format($totalNilaiKompetensi, 2) }} / {{ number_format($totalNilaiStandarKompetensi, 2) }} × 100% =</p>
        <p><strong>{{ number_format($persentaseKompetensi, 2) }}%</strong></p>
    </div>
</body>
</html>

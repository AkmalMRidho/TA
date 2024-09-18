@extends('kokape.dashboard')

@section('content')
<div class="container mt-1">
    <h3 class="text-center">Grafik Matriks Kompetensi</h3>
    <div class="form-group">
        <label for="roleSelect">Pilih Role:</label>
        <select class="form-select" id="roleSelect" onchange="updateChart()">
            <option value="dosen">Dosen</option>
            <option value="struktural">Struktural</option>
            <option value="teknisi_administrasi">Teknisi & Administrasi</option>
        </select>
    </div>
    <canvas id="kompetensiChart" class="mt-4"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dosenData = @json($dosenData);
    const tenagaKependidikanDataStruktural = @json($tenagaKependidikanDataStruktural);
    const tenagaKependidikanDataTeknisiAdministrasi = @json($tenagaKependidikanDataTeknisiAdministrasi);

    const ctx = document.getElementById('kompetensiChart').getContext('2d');
    let kompetensiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dosenData.map(item => item.name),
            datasets: [{
                label: 'Nilai Kompetensi',
                data: dosenData.map(item => item.kompetensi),
                backgroundColor: 'rgba(0, 100, 0, 0.2)',
                borderColor: 'rgba(0, 100, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function updateChart() {
        const selectedRole = document.getElementById('roleSelect').value;
        let data;
        if (selectedRole === 'dosen') {
            data = dosenData;
        } else if (selectedRole === 'struktural') {
            data = tenagaKependidikanDataStruktural;
        } else {
            data = tenagaKependidikanDataTeknisiAdministrasi;
        }
        kompetensiChart.data.labels = data.map(item => item.name);
        kompetensiChart.data.datasets[0].data = data.map(item => item.kompetensi);
        kompetensiChart.update();
    }
</script>
@endsection

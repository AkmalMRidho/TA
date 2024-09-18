<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\RiwayatPendidikan;
use App\Models\Keterampilan;
use App\Models\Tendik;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Evaluation;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PenjaminanController extends Controller
{
    public function grafikKompetensi()
    {
        $dosenEvaluations = Evaluation::whereNotNull('dosen_id')
            ->with('dosen.user:id,name') 
            ->get();
            
        $dosenData = $dosenEvaluations->map(function($evaluation) {
            return [
                'name' => $evaluation->dosen->user->name,
                'kompetensi' => $evaluation->kompetensi
            ];
        });

        $rolesStruktural = ['Ketua Jurusan', 'Koordinator Program Studi', 'Sekretaris Jurusan', 'Kalab TI'];
        $rolesTeknisiAdministrasi = ['Teknisi Lab TI', 'Staf Administrasi Prodi'];

        $tenagaKependidikanEvaluationsStruktural = Evaluation::whereHas('tendik', function ($query) use ($rolesStruktural) {
            $query->whereIn('jabatan', $rolesStruktural);
        })->with('tendik.user:id,name')->get();
        
        $tenagaKependidikanDataStruktural = $tenagaKependidikanEvaluationsStruktural->map(function($evaluation) {
            return [
                'name' => $evaluation->tendik->user->name,
                'kompetensi' => $evaluation->kompetensi
            ];
        });

        $tenagaKependidikanEvaluationsTeknisiAdministrasi = Evaluation::whereHas('tendik', function ($query) use ($rolesTeknisiAdministrasi) {
            $query->whereIn('jabatan', $rolesTeknisiAdministrasi);
        })->with('tendik.user:id,name')->get();
        
        $tenagaKependidikanDataTeknisiAdministrasi = $tenagaKependidikanEvaluationsTeknisiAdministrasi->map(function($evaluation) {
            return [
                'name' => $evaluation->tendik->user->name,
                'kompetensi' => $evaluation->kompetensi
            ];
        });

        $dosenUsers = User::where('role', 'dosen')->get();

        return view('penjaminan.grafik', [
            'dosenData' => $dosenData,
            'tenagaKependidikanDataStruktural' => $tenagaKependidikanDataStruktural,
            'tenagaKependidikanDataTeknisiAdministrasi' => $tenagaKependidikanDataTeknisiAdministrasi,
            'dosenUsers' => $dosenUsers,
        ]);
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'dosen'); // Default filter to 'dosen'

        switch ($filter) {
            case 'struktural':
                $users = User::whereIn('role', ['Ketua Jurusan', 'Koordinator Program Studi', 'Sekretaris Jurusan', 'Kalab TI'])->paginate(5);
                break;
            case 'teknisi-administrasi':
                $users = User::whereIn('role', ['Teknisi Lab TI', 'Staf Administrasi Prodi'])->paginate(5);
                break;
            default:
                $users = User::where('role', 'Dosen')->paginate(5);
                break;
        }

        return view('penjaminan.matrik', compact('users', 'filter'));
    }

    public function show($id)
    {
        $dosen = Dosen::with(['user', 'riwayatPendidikan', 'pelatihan', 'keterampilan', 'evaluations', 'mataKuliahDosen'])
                    ->where('user_id', $id)->first();

        $tendik = Tendik::with(['user', 'riwayatPendidikan', 'pelatihan', 'keterampilan'])
                        ->where('user_id', $id)->first();

        if (!$dosen && !$tendik) {
            abort(404, 'Data dosen atau tendik tidak ditemukan.');
        }

        $nilai = $dosen ? Evaluation::where('dosen_id', $dosen->id)->first() : null;

        if (!$nilai && $tendik) {
            $nilai = Evaluation::where('tendik_id', $tendik->id)->first();
        }

        return view('penjaminan.detail', [
            'entity' => $dosen ?? $tendik,
            'user' => $dosen ? $dosen->user : $tendik->user,
            'riwayatPendidikan' => $dosen ? $dosen->riwayatPendidikan : $tendik->riwayatPendidikan,
            'pelatihan' => $dosen ? $dosen->pelatihan : $tendik->pelatihan,
            'keterampilan' => $dosen ? $dosen->keterampilan : $tendik->keterampilan,
            'mataKuliah' => $dosen ? $dosen->mataKuliahDosen : [],
            'nilai' => $nilai,
            'proAct' => $nilai ? $nilai->Pro_Act : null,
        ]);
    }
    public function analisaGap(Request $request)
    {
        $filter = $request->get('filter', 'dosen');

        if ($filter == 'struktural') {
            $roles = ['Ketua Jurusan', 'Koordinator Program Studi', 'Sekretaris Jurusan', 'Kalab TI'];
            $users = User::whereHas('tendik', function ($query) use ($roles) {
                $query->whereIn('jabatan', $roles);
            })->with('tendik.evaluations')->get();
        } elseif ($filter == 'teknisi-administrasi') {
            $roles = ['Teknisi Lab TI', 'Staf Administrasi Prodi'];
            $users = User::whereHas('tendik', function ($query) use ($roles) {
                $query->whereIn('jabatan', $roles);
            })->with('tendik.evaluations')->get();
        } else {
            $users = User::whereHas($filter)->with($filter . '.evaluations')->get();
        }

        // Analisa gap
        $analisaGaps = [];
        $totalNilaiKompetensi = 0;
        $totalNilaiStandarKompetensi = 0;

        foreach ($users as $user) {
            $entity = $filter == 'dosen' ? $user->dosen : $user->tendik;
            $nilaiKompetensi = 0;

            if ($entity && $entity->evaluations->isNotEmpty()) {
                $nilaiKompetensi = $entity->evaluations->sum('kompetensi');
            }

            $nilaiStandarKompetensi = 2.00;

            $analisaGaps[] = [
                'jabatan' => $filter == 'dosen' ? 'Dosen' : $entity->jabatan,
                'nip' => $entity->nip,
                'pemangku_jabatan' => $user->name,
                'nilai_kompetensi' => $nilaiKompetensi,
                'nilai_standar_kompetensi' => $nilaiStandarKompetensi,
            ];

            $totalNilaiKompetensi += $nilaiKompetensi;
            $totalNilaiStandarKompetensi += $nilaiStandarKompetensi;
        }

        $persentaseKompetensi = $totalNilaiStandarKompetensi != 0 ? round(($totalNilaiKompetensi / $totalNilaiStandarKompetensi) * 100, 2) : 0;

        return view('penjaminan.analisa-gap', [
            'filter' => $filter,
            'analisaGaps' => $analisaGaps,
            'totalNilaiKompetensi' => $totalNilaiKompetensi,
            'totalNilaiStandarKompetensi' => $totalNilaiStandarKompetensi,
            'persentaseKompetensi' => $persentaseKompetensi,
        ]);
    }
}

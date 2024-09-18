<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Evaluation;
use App\Models\User;
use Mpdf\Mpdf;
use App\Models\Tendik;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MatriksExport;

use Illuminate\Support\Facades\Validator;

class QAController extends Controller
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

        return view('qa.grafik-kompetensi', [
            'dosenData' => $dosenData,
            'tenagaKependidikanDataStruktural' => $tenagaKependidikanDataStruktural,
            'tenagaKependidikanDataTeknisiAdministrasi' => $tenagaKependidikanDataTeknisiAdministrasi,
            'dosenUsers' => $dosenUsers,
        ]);
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'dosen'); 

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

        return view('qa.nilai-kompetensi', compact('users', 'filter'));
    }

    public function create($userId)
    {
        $dosen = Dosen::with(['user', 'riwayatPendidikan', 'pelatihan', 'keterampilan'])->where('user_id', $userId)->first();
        
        $tendik = Tendik::with(['user', 'riwayatPendidikan', 'pelatihan', 'keterampilan'])->where('user_id', $userId)->first();
        
        if (!$dosen && !$tendik) {
            abort(404, 'Data dosen atau tendik tidak ditemukan.');
        }
        
        $dosenEvaluation = $dosen ? Evaluation::where('dosen_id', $dosen->id)->first() : null;
        
        $tendikEvaluation = $tendik ? Evaluation::where('tendik_id', $tendik->id)->first() : null;
        
        return view('qa.nilai', compact('dosen', 'tendik', 'dosenEvaluation', 'tendikEvaluation'));
    }
    
    public function store(Request $request, $userId)
    {
        $request->validate([
            'riwayat_pendidikan' => 'required|integer',
            'pelatihan' => 'required|array',
            'pelatihan.*' => 'required|integer', 
            'golongan' => 'required|integer',
            'pangkat' => 'required|integer',
            'umur' => 'required|integer',
        ]);
    
        // Hitung total nilai (jumlah)
        $totalNilai = $request->riwayat_pendidikan +
                      array_sum($request->pelatihan) +
                      $request->golongan +
                      $request->pangkat +
                      $request->lama_jabatan +
                      $request->umur;
    
        // Hitung jumlah nilai yang dinilai
        $jumlahNilai = count($request->pelatihan) + 4; // 4 adalah jumlah atribut lain yang dinilai (riwayat_pendidikan, golongan, pangkat, umur)
    
        // Hitung nilai kompetensi (rata-rata)
        $nilaiKompetensi = $jumlahNilai > 0 ? $totalNilai / $jumlahNilai : 0;
        $nilaiKompetensi = number_format($nilaiKompetensi, 2, '.', '');
    
        $dosen = Dosen::where('user_id', $userId)->first();
        $tendik = Tendik::where('user_id', $userId)->first();
    
        if ($dosen) {
            $evaluation = Evaluation::where('dosen_id', $dosen->id)->first();
    
            if ($evaluation) {
                $evaluation->riwayat_pendidikan = $request->riwayat_pendidikan;
                $evaluation->pelatihan = json_encode($request->pelatihan);
                $evaluation->golongan = $request->golongan;
                $evaluation->pangkat = $request->pangkat;
                $evaluation->umur = $request->umur;
                $evaluation->Pro_Act = $request->Pro_Act;
                $evaluation->jumlah = $totalNilai;
                $evaluation->kompetensi = $nilaiKompetensi;
                $evaluation->save();
            } else {
                $evaluation = new Evaluation();
                $evaluation->user_id = auth()->id();
                $evaluation->dosen_id = $dosen->id;
                $evaluation->riwayat_pendidikan = $request->riwayat_pendidikan;
                $evaluation->pelatihan = json_encode($request->pelatihan);
                $evaluation->golongan = $request->golongan;
                $evaluation->pangkat = $request->pangkat;
                $evaluation->umur = $request->umur;
                $evaluation->Pro_Act = $request->Pro_Act;
                $evaluation->jumlah = $totalNilai;
                $evaluation->kompetensi = $nilaiKompetensi;
                $evaluation->save();
            }
        } elseif ($tendik) {
            $evaluation = Evaluation::where('tendik_id', $tendik->id)->first();
    
            if ($evaluation) {
                $evaluation->riwayat_pendidikan = $request->riwayat_pendidikan;
                $evaluation->pelatihan = json_encode($request->pelatihan);
                $evaluation->golongan = $request->golongan;
                $evaluation->pangkat = $request->pangkat;
                $evaluation->umur = $request->umur;
                $evaluation->lama_jabatan = $request->lama_jabatan;
                $evaluation->Pro_Act = $request->Pro_Act;
                $evaluation->jumlah = $totalNilai;
                $evaluation->kompetensi = $nilaiKompetensi;
                $evaluation->save();
            } else {
                $evaluation = new Evaluation();
                $evaluation->user_id = auth()->id();
                $evaluation->tendik_id = $tendik->id;
                $evaluation->riwayat_pendidikan = $request->riwayat_pendidikan;
                $evaluation->pelatihan = json_encode($request->pelatihan);
                $evaluation->golongan = $request->golongan;
                $evaluation->pangkat = $request->pangkat;
                $evaluation->umur = $request->umur;
                $evaluation->lama_jabatan = $request->lama_jabatan;
                $evaluation->Pro_Act = $request->Pro_Act;
                $evaluation->jumlah = $totalNilai;
                $evaluation->kompetensi = $nilaiKompetensi;
                $evaluation->save();
            }
        }
    
        return redirect()->route('qa.nilai-kompetensi')->with('success', 'Nilai kompetensi berhasil disimpan.');
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

        return view('qa.detail', [
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

        return view('qa.analisa-gap', [
            'filter' => $filter,
            'analisaGaps' => $analisaGaps,
            'totalNilaiKompetensi' => $totalNilaiKompetensi,
            'totalNilaiStandarKompetensi' => $totalNilaiStandarKompetensi,
            'persentaseKompetensi' => $persentaseKompetensi,
        ]);
    }

    public function indexakun()
    {
        $users = User::paginate(8);
        return view('qa.manajemen-akun', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('qa.edit-akun', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('qa.manajemen-akun')->with('success', 'Akun berhasil diperbarui');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('qa.manajemen-akun')->with('success', 'Akun berhasil dihapus');
    }

    public function createAkun()
    {
        return view('qa.tambah-akun');
    }

    public function storeAkun(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('qa.manajemen-akun')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function downloadPdf(Request $request)
    {
        $type = $request->get('matrix_type');

        if ($type == 'dosen') {
            $data = Dosen::with(['user', 'riwayatPendidikan', 'pelatihan', 'keterampilan', 'evaluations', 'mataKuliahDosen'])->get();
        } elseif ($type == 'struktural') {
            $data = Tendik::whereIn('jabatan', ['Koordinator Program Studi', 'Ketua Jurusan', 'Sekretaris Jurusan', 'Kalab TI'])
                ->with(['user','riwayatPendidikan', 'pelatihan', 'keterampilan', 'evaluations'])
                ->get();
        } elseif ($type == 'teknisi-administrasi') {
            $data = Tendik::whereIn('jabatan', ['Teknisi Laboratorium Informatika', 'Staf Administrasi Prodi'])
                ->with(['user','riwayatPendidikan', 'pelatihan', 'keterampilan'])
                ->get();
        } else {
            return redirect()->back()->with('error', 'Jenis matriks tidak valid');
        }

        foreach ($data as $entity) {
            if ($type == 'dosen') {
                $entity->nilai = Evaluation::where('dosen_id', $entity->id)->first();
            } else {
                $entity->nilai = Evaluation::where('tendik_id', $entity->id)->first();
            }
        }

        $html = view('qa.matriks_pdf', compact('data', 'type'))->render();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('matriks_' . $type . '.pdf', 'I');
    }

    public function downloadAnalisaPDF(Request $request)
    {
        $filter = $request->get('matrix_type', 'dosen'); 

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

        $analisaGaps = [];
        $totalNilaiKompetensi = 0;
        $totalNilaiStandarKompetensi = 0;

        foreach ($users as $user) {
            $entity = $filter == 'dosen' ? $user->dosen : $user->tendik;
            $nilaiKompetensi = 0;

            if ($entity && $entity->evaluations->isNotEmpty()) {
                $nilaiKompetensi = $entity->evaluations->sum('kompetensi');
            }

            $nilaiStandarKompetensi = 2.00; // Nilai standar kompetensi tetap

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

        $persentaseKompetensi = $totalNilaiStandarKompetensi != 0 
            ? round(($totalNilaiKompetensi / $totalNilaiStandarKompetensi) * 100, 2) 
            : 0;
        $html = view('qa.analisagap_pdf', [
            'filter' => $filter,
            'analisaGaps' => $analisaGaps,
            'totalNilaiKompetensi' => $totalNilaiKompetensi,
            'totalNilaiStandarKompetensi' => $totalNilaiStandarKompetensi,
            'persentaseKompetensi' => $persentaseKompetensi,
        ])->render();

        // Buat instance mPDF
        $mpdf = new Mpdf();

        $mpdf->WriteHTML($html);

        return $mpdf->Output("Analisa_GAP_{$filter}.pdf", 'I');
    }
    public function downloadExcel(Request $request)
{
    $type = $request->get('matrix_type');

    if ($type == 'dosen') {
        $data = Dosen::with(['user', 'riwayatPendidikan', 'pelatihan', 'keterampilan', 'evaluations', 'mataKuliahDosen'])->get();
    } elseif ($type == 'struktural') {
        $data = Tendik::whereIn('jabatan', ['Koordinator Program Studi', 'Ketua Jurusan', 'Sekretaris Jurusan', 'Kalab TI'])
            ->with(['user','riwayatPendidikan', 'pelatihan', 'keterampilan', 'evaluations'])
            ->get();
    } elseif ($type == 'teknisi-administrasi') {
        $data = Tendik::whereIn('jabatan', ['Teknisi Laboratorium Informatika', 'Staf Administrasi Prodi'])
            ->with(['user','riwayatPendidikan', 'pelatihan', 'keterampilan'])
            ->get();
    } else {
        return redirect()->back()->with('error', 'Jenis matriks tidak valid');
    }

    foreach ($data as $entity) {
        if ($type == 'dosen') {
            $entity->nilai = Evaluation::where('dosen_id', $entity->id)->first();
        } else {
            $entity->nilai = Evaluation::where('tendik_id', $entity->id)->first();
        }
    }

    $fileName = 'matriks_' . $type . '.xlsx';

    return Excel::download(new MatriksExport($data), $fileName);
}
}

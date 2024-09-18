<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MataKuliahDosen;
use App\Models\Pelatihan;
use App\Models\RiwayatPendidikan;
use App\Models\Keterampilan;
use App\Models\Dosen;
use App\Models\Evaluation;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DosenController extends Controller
{
    public function create()
    {
        Log::info('Create method called');
        $user_id = Auth::id();
        $dosen = Dosen::where('user_id', $user_id)->first();

        if ($dosen) {
            return redirect()->route('lengkapi-kompetensi.edit', $dosen->id);
        }
        return view('dosen.lengkapi-kompetensi');
    }

    public function store(Request $request)
    {
        Log::info('Store method called');
        $validator = Validator::make($request->all(), [
            'mata_kuliah.*' => 'required|string',
            'nama_pelatihan.*' => 'required|string',
            'expired_sertifikat.*' => 'required|date',
            'sertifikat_path.*' => 'required|file',
            'riwayat_pendidikan.*' => 'required|string',
            'golongan' => 'required|string',
            'pangkat' => 'required|string',
            'umur' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Simpan atau update data dosen
        $user_id = Auth::id();
        $dosen = Dosen::where('user_id', $user_id)->first();
    
        if ($dosen) {
            // Jika data dosen sudah ada, maka akan melakukan update
            $dosen->nip = $request->nip; 
            $dosen->tanggal_lahir = $request->tanggal_lahir; 
            $dosen->save();
        } else {
            $dosen = new Dosen();
            $dosen->user_id = $user_id;
            $dosen->nip = $request->nip; 
            $dosen->tanggal_lahir = $request->tanggal_lahir; 
            $dosen->save();
        }
    
        foreach ($request->mata_kuliah as $mataKuliah) {
            MataKuliahDosen::create([
                'dosen_id' => $dosen->id,
                'mata_kuliah' => $mataKuliah,
            ]);
        }
    
        foreach ($request->nama_pelatihan as $index => $namaPelatihan) {

            $path = $request->file('sertifikat')[$index]->store('sertifikat', 'public');

            Pelatihan::create([

                'dosen_id' => $dosen->id,
                
                'user_id' => $user_id,

                'nama_pelatihan' => $namaPelatihan,

                'expired_sertifikat' => $request->expired_sertifikat[$index],

                'sertifikat_path' => $path,

            ]);
          }
            
        foreach ($request->riwayat_pendidikan as $riwayatPendidikan) {
            RiwayatPendidikan::create([
                'dosen_id' => $dosen->id,
                'riwayat_pendidikan' => $riwayatPendidikan,
            ]);
        }
    
        Keterampilan::create([
            'dosen_id' => $dosen->id,
            'golongan' => $request->golongan,
            'pangkat' => $request->pangkat,
            'umur' => $request->umur,
        ]);
    
        return redirect()->route('dashboard.dosen')->with('success', 'Data berhasil disimpan.');
    }

    public function edit()
    {
        $user_id = Auth::id();
        $dosen = Dosen::with(['mataKuliahDosen', 'pelatihan', 'riwayatPendidikan', 'keterampilan'])
                        ->where('user_id', $user_id)
                        ->first();
    
        if (!$dosen) {
            return redirect()->route('lengkapi-kompetensi.create')->with('error', 'Anda belum melengkapi kompetensi.');
        }
    
        return view('dosen.edit-lengkapi-kompetensi', compact('dosen'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|integer',
            'mata_kuliah.*' => 'sometimes|required|string',
            'nama_pelatihan.*' => 'sometimes|required|string',
            'expired_sertifikat.*' => 'sometimes|required|date',
            'riwayat_pendidikan.*' => 'sometimes|required|string',
            'golongan' => 'required|string',
            'pangkat' => 'required|string',
            'umur' => 'required|integer',
            'sertifikat_path.*' => 'sometimes|file',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dosen = Dosen::findOrFail($id);
        $dosen->update([
            'nip' => $request->nip,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        if ($request->filled('mata_kuliah')) {
            $dosen->mataKuliahDosen()->delete(); // Hapus data lama
            foreach ($request->mata_kuliah as $mataKuliah) {
                MataKuliahDosen::create([
                    'dosen_id' => $dosen->id,
                    'mata_kuliah' => $mataKuliah,
                ]);
            }
        }

        $existingPelatihan = Pelatihan::where('dosen_id', $dosen->id)->get();
        foreach ($request->nama_pelatihan as $index => $namaPelatihan) {
            $pelatihan = $existingPelatihan->get($index);

            // Jika ada file sertifikat baru, simpan, jika tidak, pertahankan yang lama
            $path = null;
            if ($request->hasFile('sertifikat_path') && isset($request->file('sertifikat_path')[$index])) {
                $path = $request->file('sertifikat_path')[$index]->store('sertifikat', 'public');
            } elseif ($pelatihan) {
                $path = $pelatihan->sertifikat_path;
            }

            Pelatihan::updateOrCreate(
                ['id' => optional($pelatihan)->id], 
                [
                    'dosen_id' => $dosen->id,
                    'nama_pelatihan' => $namaPelatihan,
                    'expired_sertifikat' => $request->expired_sertifikat[$index],
                    'sertifikat_path' => $path,
                ]
            );
        }

        // Update data riwayat pendidikan jika ada input baru
        if ($request->filled('riwayat_pendidikan')) {
            $dosen->riwayatPendidikan()->delete(); 
            foreach ($request->riwayat_pendidikan as $riwayatPendidikan) {
                RiwayatPendidikan::create([
                    'dosen_id' => $dosen->id,
                    'riwayat_pendidikan' => $riwayatPendidikan,
                ]);
            }
        }

        $dosen->keterampilan()->delete(); 
        Keterampilan::create([
            'dosen_id' => $dosen->id,
            'golongan' => $request->golongan,
            'pangkat' => $request->pangkat,
            'umur' => $request->umur,
        ]);

        return redirect()->route('dashboard.dosen')->with('success', 'Data berhasil diperbarui.');
    }

    public function index()
    {
        $user = auth()->user();
           $dosen = Dosen::where('user_id', $user->id)->first();
           if (!$dosen) {
               return redirect()->route('lengkapi-kompetensi')->with('error', 'Anda belum melengkapi kompetensi.');
           }
           
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $mataKuliah = MataKuliahDosen::where('dosen_id', $dosen->id)->get();

        $pelatihan = Pelatihan::where('dosen_id', $dosen->id)->get();

        $riwayatPendidikan = RiwayatPendidikan::where('dosen_id', $dosen->id)->get();

        $keterampilan = collect([Keterampilan::where('dosen_id', $dosen->id)->first()]);

        $evaluation = Evaluation::where('dosen_id', $dosen->id)->first();

        $nilai = Evaluation::where('dosen_id', $dosen->id)->first();

        return view('dosen.matrik', compact('user', 'dosen', 'mataKuliah', 'pelatihan', 'riwayatPendidikan', 'keterampilan','nilai'));
    }

    public function showCVForm()
    {
        return view('dosen.cvform');
    }

    public function generateCV(Request $request)
    {
        $user_id = Auth::id();
        $dosen = Dosen::with(['pelatihan', 'riwayatPendidikan', 'keterampilan'])
                        ->where('user_id', $user_id)
                        ->first();

        if (!$dosen) {
            return redirect()->route('lengkapi-kompetensi.create')->with('error', 'Anda belum melengkapi kompetensi.');
        }

        $user = Auth::user(); 

        $data = $request->input('data', []);
        $foto = $request->file('foto');
        $linkedin = $request->input('linkedin');
        $github = $request->input('github');
        $keterampilan = $request->input('keterampilan', []);

        $html = view('dosen.cv', compact('user', 'dosen', 'data', 'foto', 'linkedin', 'github', 'keterampilan'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('CV.pdf', 'I'); 
    }
}

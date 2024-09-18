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

class TekaController extends Controller
{
    public function create()
    {
        Log::info('Create method called');

        //untuk  meriksa apakah tendik sudah mengisi formulir sebelumnya
        $user_id = Auth::id();
        $tendik = Tendik::where('user_id', $user_id)->first();

        if ($tendik) {
            return redirect()->route('lengkapi-kompetensi-teka.edit', $tendik->id);
        }
        return view('TEKA.lengkapi-kompetensi');
    }

    public function store(Request $request)
    {
        Log::info('Store method called');
        
        $validator = Validator::make($request->all(), [
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

        $user_id = Auth::id();
        $tendik = Tendik::where('user_id', $user_id)->first();

        if ($tendik) {
            $tendik->nip = $request->nip; 
            $tendik->tanggal_lahir = $request->tanggal_lahir; 
            $tendik->save();
        } else {
            $tendik = new Tendik();
            $tendik->user_id = $user_id;
            $tendik->nip = $request->nip;
            $tendik->tanggal_lahir = $request->tanggal_lahir; 
            $tendik->jabatan = $request->jabatan; 
            $tendik->save();
        }

        foreach ($request->nama_pelatihan as $index => $namaPelatihan) {
            $path = $request->file('sertifikat')[$index]->store('sertifikat', 'public');

            Pelatihan::create([
                'tendik_id' => $tendik->id,
                'user_id' => $user_id,
                'nama_pelatihan' => $namaPelatihan,
                'expired_sertifikat' => $request->expired_sertifikat[$index],
                'sertifikat_path' => $path,
            ]);
        }

        foreach ($request->riwayat_pendidikan as $riwayatPendidikan) {
            RiwayatPendidikan::create([
                'tendik_id' => $tendik->id,
                'riwayat_pendidikan' => $riwayatPendidikan,
            ]);
        }

        Keterampilan::create([
            'tendik_id' => $tendik->id,
            'golongan' => $request->golongan,
            'pangkat' => $request->pangkat,
            'umur' => $request->umur,
        ]);

        return redirect()->route('dashboard.teka')->with('success', 'Data berhasil disimpan.');
    }

    public function edit()
    {
        $user_id = Auth::id();
        $tendik = Tendik::where('user_id', $user_id)->first();

        if (!$tendik) {
            return redirect()->back()->with('error', 'Data tendik tidak ditemukan.');
        }

        return view('TEKA.edit-lengkapi-kompetensi', compact('tendik'));
    }

    public function update(Request $request)
    {
        $user_id = Auth::id();
        $tendik = Tendik::where('user_id', $user_id)->first();

        if (!$tendik) {
            return redirect()->back()->with('error', 'Data tendik tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'nip' => 'required|string',
            'jabatan' => 'required|string',
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

        $tendik->update([
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        $existingPelatihan = Pelatihan::where('tendik_id', $tendik->id)->get();
        foreach ($request->nama_pelatihan as $index => $namaPelatihan) {
            $pelatihan = $existingPelatihan->get($index);

            $path = null;
            if ($request->hasFile('sertifikat_path') && isset($request->file('sertifikat_path')[$index])) {
                $path = $request->file('sertifikat_path')[$index]->store('sertifikat', 'public');
            } elseif ($pelatihan) {
                $path = $pelatihan->sertifikat_path; 
            }

            Pelatihan::updateOrCreate(
                ['id' => optional($pelatihan)->id], 
                [
                    'tendik_id' => $tendik->id,
                    'nama_pelatihan' => $namaPelatihan,
                    'expired_sertifikat' => $request->expired_sertifikat[$index],
                    'sertifikat_path' => $path,
                ]
            );
        }

        if ($request->filled('riwayat_pendidikan')) {
            $tendik->riwayatPendidikan()->delete();
            foreach ($request->riwayat_pendidikan as $riwayatPendidikan) {
                RiwayatPendidikan::create([
                    'tendik_id' => $tendik->id,
                    'riwayat_pendidikan' => $riwayatPendidikan,
                ]);
            }
        }

        $tendik->keterampilan()->delete(); 
        Keterampilan::create([
            'tendik_id' => $tendik->id,
            'golongan' => $request->golongan,
            'pangkat' => $request->pangkat,
            'umur' => $request->umur,
            'lama_jabatan' => $request->lama_jabatan,
        ]);

        return redirect()->route('dashboard.teka')->with('success', 'Data tendik berhasil diperbarui.');
    }

    public function show()
    {
        $user = auth()->user();

           $tendik = Tendik::where('user_id', $user->id)->first();
           if (!$tendik) {
               return redirect()->route('lengkapi-kompetensi-teka')->with('error', 'Anda belum melengkapi kompetensi.');
           }
           
        $tendik = Tendik::where('user_id', $user->id)->firstOrFail();

        $pelatihan = Pelatihan::where('tendik_id', $tendik->id)->get();

        $riwayatPendidikan = RiwayatPendidikan::where('tendik_id', $tendik->id)->get();

        $keterampilan = collect([Keterampilan::where('tendik_id', $tendik->id)->first()]);

        $evaluation = Evaluation::where('tendik_id', $tendik->id)->first();

        $nilai = Evaluation::where('tendik_id', $tendik->id)->first();

        return view('TEKA.matrik-teka', compact('user', 'tendik', 'pelatihan', 'riwayatPendidikan', 'keterampilan','nilai'));
    }

    public function showCVForm()
    {
        return view('TEKA.cvform');
    }

    public function generateCV(Request $request)
    {
        $user_id = Auth::id();
        $tendik = Tendik::with(['pelatihan', 'riwayatPendidikan', 'keterampilan'])
                        ->where('user_id', $user_id)
                        ->first();

        if (!$tendik) {
            return redirect()->route('lengkapi-kompetensi-teka.create')->with('error', 'Anda belum melengkapi kompetensi.');
        }

        $user = Auth::user(); 

        $data = $request->input('data', []);
        $foto = $request->file('foto');
        $linkedin = $request->input('linkedin');
        $github = $request->input('github');
        $keterampilan = $request->input('keterampilan', []);

        $html = view('TEKA.cv', compact('user', 'tendik', 'data', 'foto', 'linkedin', 'github', 'keterampilan'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('CV.pdf', 'I'); // 'I' untuk browser, 'D' untuk unduh, 'F' untuk simpan di server
    }
}

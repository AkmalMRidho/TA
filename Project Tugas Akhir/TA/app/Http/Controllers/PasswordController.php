<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller
{
    /**
     * Display the password change form.
     */
    public function indexQA()
{
    return view('qa.ubah-password');
}

public function indexDosen()
{
    return view('dosen.ubah-password');
}

public function indexKajur()
{
    return view('kokape.ubah-password');
}

public function indexKaprodi()
{
    return view('kokape.ubah-password');
}

public function indexTeka()
{
    return view('teka.ubah-password');
}

public function indexPenjaminan()
{
    return view('penjaminan.ubah-password');
}

    /**
     * Update the password.
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        Session::flash('success', 'Password berhasil diubah!');

        switch ($user->role) {
            case 'Quality Assurance':
                return redirect()->route('dashboard.qa');
            case 'Dosen':
                return redirect()->route('dashboard.dosen');
            case 'Ketua Jurusan':
            case 'Koordinator Program Studi':
                return redirect()->route('dashboard.kaprodi');
            case 'Sekretaris Jurusan':
            case 'Kalab TI':
            case 'Teknisi Lab TI':
            case 'Staf Administrasi Prodi':
                return redirect()->route('dashboard.teka');
            case 'Penjaminan Mutu & Pengembangan Pembelajaran':
                return redirect()->route('dashboard.penjaminan');
            default:
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller
{
    public function show()
    {
        return view('ubah-password'); 
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {

            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        Session::flash('success', 'Profil dan Password berhasil diperbarui!');
        if ($user->role == 'Quality Assurance') {
            return redirect()->route('dashboard.qa');
        } elseif ($user->role == 'Dosen') {
            return redirect()->route('dashboard.dosen');
        } elseif ($user->role == 'Ketua Jurusan' || $user->role == 'Koordinator Program Studi') {
            return redirect()->route('dashboard.kaprodi');
        } elseif ($user->role == 'Sekretaris Jurusan' || $user->role == 'Kalab TI' || $user->role == 'Teknisi Lab TI' || $user->role == 'Staf Administrasi Prodi' ) {
            return redirect()->route('dashboard.teka');
        } elseif ($user->role == 'Penjaminan Mutu & Pengembangan Pembelajaran') {
            return redirect()->route('dashboard.penjaminan');
        }
        
        return redirect()->route('home'); 
    }
}
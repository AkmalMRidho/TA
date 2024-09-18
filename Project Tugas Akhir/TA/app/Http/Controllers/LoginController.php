<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function actionlogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Email salah');
        }

        if (!Auth::attempt($credentials)) {
            return redirect()->route('login')->with('error', 'Password salah');
        }

        return $this->redirectUser();
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    protected function redirectUser()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            switch ($role) {
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
                    return redirect()->route('home');
            }
        }

        return redirect()->route('login');
    }

    public function impersonate($id)
    {
        $user = User::findOrFail($id);
        Session::put('impersonate', Auth::id());
        Auth::login($user);

        return redirect()->route('dashboard.dosen');
    }

    public function leaveImpersonate()
    {
        $originalUserId = Session::get('impersonate');

        if ($originalUserId) {
            Auth::loginUsingId($originalUserId);
            Session::forget('impersonate');

            return redirect()->route('dashboard.qa');
        }

        return redirect()->route('login');
    }
}
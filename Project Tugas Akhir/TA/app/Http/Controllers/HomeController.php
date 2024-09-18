<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Tendik;
use Carbon\Carbon;
use Auth;
  
class HomeController extends Controller
{
  
    public function qaDashboard()
    {
        return view('qa.home');
    }

    public function dosenDashboard()
    {
        $notifications = $this->getNotifications();
        return view('dosen.home', compact('notifications'));
    }

    public function kaprodiDashboard()
    {
        $notifications = $this->getNotifications();
        return view('kokape.home', compact('notifications'));
    }

    public function tekaDashboard()
    {
        $notifications = $this->getNotifications();
        return view('TEKA.home', compact('notifications'));
    }

    public function penjaminanDashboard()
    {
        return view('penjaminan.home');
    }

    private function getNotifications()
    {
        $user = auth()->user();
        $notifications = [];

        $query = Pelatihan::query();
        if ($user->role == 'Dosen') {
            $query->where('user_id', $user->id);
        } else {
            $query->where('user_id', $user->id);
        }

        $pelatihans = $query->whereDate('expired_sertifikat', '<=', Carbon::now()->addMonth())->get();

        foreach ($pelatihans as $pelatihan) {
            if (Carbon::parse($pelatihan->expired_sertifikat)->isPast()) {
                $notifications[] = "Sertifikat untuk pelatihan {$pelatihan->nama_pelatihan} telah expired pada {$pelatihan->expired_sertifikat}. Segera perbarui sertifikat Anda!";
            } else {
                $notifications[] = "Sertifikat untuk pelatihan {$pelatihan->nama_pelatihan} akan expired pada {$pelatihan->expired_sertifikat}. Segera perbarui sertifikat Anda!";
            }
        }

        return $notifications;
    }
}
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\QAController;
use App\Http\Controllers\TekaController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\PenjaminanController;
use App\Exports\AnalisaGAPExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MatriksExport;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::middleware('auth')->group(function () {
    Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');
    Route::get('dashboard/qa', [HomeController::class, 'qaDashboard'])->middleware('role:Quality Assurance')->name('dashboard.qa');
    Route::get('dashboard/dosen', [HomeController::class, 'dosenDashboard'])->middleware('role:Dosen')->name('dashboard.dosen');
    Route::get('dashboard/kaprodi', [HomeController::class, 'kaprodiDashboard'])->middleware('role:Ketua Jurusan,Koordinator Program Studi')->name('dashboard.kaprodi');
    Route::get('dashboard/Matrik', [HomeController::class, 'tekaDashboard'])->middleware('role:Sekretaris Jurusan,Kalab TI, Teknisi Lab TI,Staf Administrasi Prodi')->name('dashboard.teka');
    Route::get('dashboard/penjaminan', [HomeController::class, 'penjaminanDashboard'])->middleware('role:Penjaminan Mutu & Pengembangan Pembelajaran')->name('dashboard.penjaminan');
    Route::get('/ubah-password/qa', [PasswordController::class, 'indexQA'])->name('ubah-password.qa');
    Route::get('/ubah-password/dosen', [PasswordController::class, 'indexDosen'])->name('ubah-password.dosen');
    Route::get('/ubah-password/teka', [PasswordController::class, 'indexTeka'])->name('ubah-password.teka');
    Route::get('/ubah-password/kaprodi', [PasswordController::class, 'indexKaprodi'])->name('ubah-password.kaprodi');
    Route::get('/ubah-password/penjaminan', [PasswordController::class, 'indexPenjaminan'])->name('ubah-password.penjaminan');
    Route::post('/ubah-password', [PasswordController::class, 'update'])->name('ubah-password.update');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'show'])->name('dashboard');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::get('/qa/grafik', [QAController::class, 'grafikKompetensi'])->name('qa.grafik');
    Route::get('/qa/{id}/detail', [QAController::class, 'show'])->name('qa.detail');
    Route::get('/grafik', [KoordinatorController::class, 'grafikKompetensi'])->name('grafik');
    Route::get('/grafik-kompetensi', [PenjaminanController::class, 'grafikKompetensi'])->name('grafikKompetensi');
    Route::get('/qa/analisa-gap', [QAController::class, 'analisaGap'])->name('qa.analisa-gap');
    Route::get('/analisa-gap', [KoordinatorController::class, 'analisaGap'])->name('analisa-gap');
    Route::get('/Matriks-Kompetensi', [PenjaminanController::class, 'index'])->name('matriksTI');
    Route::get('/Matriks/{id}/detail', [PenjaminanController::class, 'show'])->name('penjaminan.detail');
    Route::get('/analisa/gap', [PenjaminanController::class, 'analisaGap'])->name('penjaminan.analisa-gap');
    Route::get('/impersonate/{id}', [LoginController::class, 'impersonate'])->name('impersonate');
    Route::get('/leave-impersonate', [LoginController::class, 'leaveImpersonate'])->name('leave.impersonate');


    Route::middleware(['auth'])->group(function () {
        Route::get('/lengkapi-kompetensi-dosen', [DosenController::class, 'create'])->name('lengkapi-kompetensi');
        Route::post('/lengkapi-kompetensi-dosen', [DosenController::class, 'store'])->name('lengkapi-kompetensi.store');
        Route::get('/lengkapi-kompetensi-dosen/edit/{id}', [DosenController::class, 'edit'])->name('lengkapi-kompetensi.edit');
        Route::post('/lengkapi-kompetensi-dosen/update/{id}', [DosenController::class, 'update'])->name('lengkapi-kompetensi.update');
        Route::get('/matrik-kompetensi', [DosenController::class, 'index'])->name('matrik-kompetensi');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/lengkapi-kompetensi', [KoordinatorController::class, 'create'])->name('lengkapi-kompetensi-kokape');
        Route::post('/lengkapi-kompetensi', [KoordinatorController::class, 'store'])->name('lengkapi-kompetensi-kokape.store');
        Route::get('/lengkapi-kompetensi/edit/{id}', [KoordinatorController::class, 'edit'])->name('lengkapi-kompetensi-kokape.edit');
        Route::post('/lengkapi-kompetensi/update/{id}', [KoordinatorController::class, 'update'])->name('lengkapi-kompetensi-kokape.update');
        Route::get('/detail-matrik-kompetensi', [KoordinatorController::class, 'show'])->name('matrik-kompetensi-kokape');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/lengkapi-kompetensii', [TekaController::class, 'create'])->name('lengkapi-kompetensi-teka');
        Route::post('/lengkapi-kompetensii', [TekaController::class, 'store'])->name('lengkapi-kompetensi-teka.store');
        Route::get('/lengkapi-kompetensii/edit/{id}', [TekaController::class, 'edit'])->name('lengkapi-kompetensi-teka.edit');
        Route::post('/lengkapi-kompetensii/update/{id}', [TekaController::class, 'update'])->name('lengkapi-kompetensi-teka.update');
        Route::get('/matrik-kompetensi-teka', [TekaController::class, 'show'])->name('matrik-kompetensi-teka');
    });

    Route::prefix('qa')->name('qa.')->group(function () {
        Route::get('/evaluations', [QAController::class, 'index'])->name('nilai-kompetensi');
        Route::get('/evaluations/create/{userId}', [QAController::class, 'create'])->name('nilai.create');
        Route::post('/evaluations/store/{userId}', [QAController::class, 'store'])->name('nilai.store');
    });

    Route::middleware(['auth', 'role:Quality Assurance'])->group(function () {
        Route::get('/qa/manajemen-akun', [QAController::class, 'indexakun'])->name('qa.manajemen-akun');
        Route::get('/qa/edit-akun/{id}', [QAController::class, 'edit'])->name('qa.edit-akun');
        Route::put('/qa/update-akun/{id}', [QAController::class, 'update'])->name('qa.update-akun');
        Route::delete('/qa/hapus-akun/{id}', [QAController::class, 'destroy'])->name('qa.hapus-akun');
        Route::get('/qa/tambah-akun', [QAController::class, 'createAkun'])->name('qa.tambah-akun');
        Route::post('/qa/tambah-akun', [QAController::class, 'storeAkun'])->name('qa.store-akun');
    });
    
    Route::get('/download-analisa-pdf', [QAController::class, 'downloadAnalisaPdf'])->name('qa.download-analisa-pdf');

    Route::get('/download-pdf', [QAController::class, 'downloadPdf'])->name('qa.download-pdf');

    Route::get('/cv-form', [KoordinatorController::class, 'showCVForm'])->name('showCVForm');
    Route::post('/generate-cv', [KoordinatorController::class, 'generateCV'])->name('generateCV');
    Route::get('/form-CV', [TekaController::class, 'showCVForm'])->name('formCV');
    Route::post('/generate-CV', [TekaController::class, 'generateCV'])->name('generate');
    Route::get('/cv-form-dosen', [DosenController::class, 'showCVForm'])->name('showCVForm-dosen');
    Route::post('/generate-cv-dosen', [DosenController::class, 'generateCV'])->name('generateCV-dosen');
    
    Route::get('/export-excel', function() {
        return Excel::download(new AnalisaGAPExport(request()->get('matrix_type')), 'analisa_gap.xlsx');
    })->name('qa.download-analisa-excel');
    
    Route::get('/download-excel', [QAController::class, 'downloadExcel'])->name('downloadExcel');

});
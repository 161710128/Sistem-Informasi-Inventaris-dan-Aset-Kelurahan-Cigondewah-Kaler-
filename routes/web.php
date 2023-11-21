<?php

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Pemeliharaan;
use App\Models\Peminjaman_barang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LurahController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenempatanController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanPegawaiController;
use App\Http\Controllers\LaporanSupplierController;
use App\Http\Controllers\PengadaanBarangController;
use App\Http\Controllers\BarangHabisPakaiController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\LaporanPemakaianBHPController;
use App\Http\Controllers\LaporanPemakaianController;
use App\Http\Controllers\LaporanPemeliharaanController;
use App\Http\Controllers\LaporanPeminjamanController;
use App\Http\Controllers\LaporanPengembalianController;
use App\Http\Controllers\PencarianBarangController;
use App\Http\Controllers\Transaksi_pengadaanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login.index');
});




Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('role:admin')->group(function () {
        Route::prefix('admin')->group(function () {

            Route::get('/dashboard', function () {
                return view('admin.index');
            })->middleware('auth');
            Route::get('/dashboard', [InventarisController::class, 'dashboard'])->name('dashboard');

            // start kategori barang
            Route::get('/kategoribarang/checkSlug', [KategoriController::class, 'checkSlug'])->middleware('auth');

            Route::resource('/kategoribarang', KategoriController::class)->middleware('auth')->parameters([
                'kategoribarang' => 'kategori:slug',
            ]);
            // end kategori barang

            // start pegawai
            Route::get('/pegawai/checkSlug', [PegawaiController::class, 'checkSlug'])->middleware('auth');
            Route::get('/pegawai/view-pdf', [PegawaiController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/pegawai/download-pdf', [PegawaiController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/pegawai', PegawaiController::class)->middleware('auth')->parameters([
                'pegawai' => 'pegawai:slug',
            ]);
            // end pegawai

            //start supplier
            Route::get('/supplier/checkSlug', [SupplierController::class, 'checkSlug'])->middleware('auth');

            Route::resource('/supplier', SupplierController::class)->middleware('auth')->parameters([
                'supplier' => 'supplier:slug',
            ]);
            // end supplier

            //start pengadaan barang

            Route::get('/transaksi/pengadaan-barang/checkSlug', [PengadaanBarangController::class, 'checkSlug'])->middleware('auth');

            Route::resource('/transaksi/pengadaan-barang', PengadaanBarangController::class)->middleware('auth')->parameters([
                'pengadaan-barang' => 'pengadaan_barang:slug',
            ]);

            // end pengadaan barang

            // start penempatan barang
            Route::get('/transaksi/penempatan-barang/checkSlug', [PenempatanController::class, 'checkSlug'])->middleware('auth');
            Route::get('/transaksi/penempatan-barang/view-pdf', [PenempatanController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/transaksi/penempatan-barang/download-pdf', [PenempatanController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/transaksi/penempatan-barang', PenempatanController::class)->middleware('auth')->parameters([
                'penempatan-barang' => 'penempatan_barang:slug',
            ]);
            // end 
            // start peminjaman barang
            Route::get('/transaksi/peminjaman-barang/checkSlug', [PeminjamanController::class, 'checkSlug'])->middleware('auth');
            Route::get('/transaksi/peminjaman-barang/view-pdf', [PeminjamanController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/transaksi/peminjaman-barang/download-pdf', [PeminjamanController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/transaksi/peminjaman-barang', PeminjamanController::class)->middleware('auth')->parameters([
                'peminjaman-barang' => 'peminjaman_barang:slug',
            ]);
            // end 
            // start pemeliharaan barang
            Route::get('/transaksi/pemeliharaan-barang/checkSlug', [PemeliharaanController::class, 'checkSlug'])->middleware('auth');
            Route::get('/transaksi/pemeliharaan-barang/view-pdf', [PemeliharaanController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/transaksi/pemeliharaan-barang/download-pdf', [PemeliharaanController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/transaksi/pemeliharaan-barang', PemeliharaanController::class)->middleware('auth')->parameters([
                'pemeliharaan-barang' => 'pemeliharaan_barang:slug',
            ]);
            // end 
            // start pengembalian barang
            Route::get('/transaksi/pengembalian-barang/checkSlug', [PengembalianController::class, 'checkSlug'])->middleware('auth');
            Route::get('/transaksi/pengembalian-barang/view-pdf', [PengembalianController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/transaksi/pengembalian-barang/download-pdf', [PengembalianController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/transaksi/pengembalian-barang', PengembalianController::class)->middleware('auth')->parameters([
                'pengembalian-barang' => 'pengembalian_barang:slug',
            ]);
            // end 
            // start pemakian barang
            Route::get('/transaksi/pemakaian-barang/checkSlug', [PemakaianController::class, 'checkSlug'])->middleware('auth');
            Route::get('/transaksi/pemakaian-barang/view-pdf', [PemakaianController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/transaksi/pemakaian-barang/download-pdf', [PemakaianController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/transaksi/pemakaian-barang', PemakaianController::class)->middleware('auth')->parameters([
                'pemakian-barang' => 'pemakian_barang:slug',
            ]);
            // end 
            // start pemakian barang
            Route::get('/transaksi/pemakaian-barangHabisPakai/checkSlug', [BarangHabisPakaiController::class, 'checkSlug'])->middleware('auth');
            Route::get('/transaksi/pemakaian-barangHabisPakai/view-pdf', [BarangHabisPakaiController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/transaksi/pemakaian-barangHabisPakai/download-pdf', [BarangHabisPakaiController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/transaksi/pemakaian-barangHabisPakai', BarangHabisPakaiController::class)->middleware('auth')->parameters([
                'pemakaian-barangHabisPakai' => 'barang_habis_pakais:slug',
            ]);
            // end


            // laporan Barang
            Route::get('/laporan/barang/checkSlug', [BarangController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/barang/view-pdf', [BarangController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/barang/download-pdf', [BarangController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/barang', BarangController::class)->middleware('auth')->parameters([
                'barang' => 'barang:slug',
            ]);
            //end
            // laporan Pengadaan Barang
            Route::get('/laporan/pengadaan/checkSlug', [Transaksi_pengadaanController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/pengadaan/view-pdf', [Transaksi_pengadaanController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/pengadaan/download-pdf', [Transaksi_pengadaanController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/pengadaan', Transaksi_pengadaanController::class)->middleware('auth')->parameters([
                'pengadaan' => 'pengadaan:slug',
            ]);
            //end
            // laporan Pegawai
            Route::get('/laporan/pegawai/checkSlug', [LaporanPegawaiController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/pegawai/view-pdf', [LaporanPegawaiController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/pegawai/download-pdf', [LaporanPegawaiController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/pegawai', LaporanPegawaiController::class)->middleware('auth')->parameters([
                'pegawai' => 'pegawai:slug',
            ]);
            //end
            Route::middleware(['auth', 'role:admin,lurah'])->group(function () {
                // laporan supplier
                Route::get('/laporan/supplier/checkSlug', [LaporanSupplierController::class, 'checkSlug'])->middleware('auth');
                Route::get('/laporan/supplier/view-pdf', [LaporanSupplierController::class, 'viewPDF'])->name('view-pdf');
                Route::post('/laporan/supplier/download-pdf', [LaporanSupplierController::class, 'downloadPDF'])->name('download-pdf');

                Route::resource('/laporan/supplier', LaporanSupplierController::class)->middleware('auth')->parameters([
                    'supplier' => 'supplier:slug',
                ]);
                //end
            });
            // laporan peminjaman
            Route::get('/laporan/peminjaman/checkSlug', [LaporanPeminjamanController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/peminjaman/view-pdf', [LaporanPeminjamanController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/peminjaman/download-pdf', [LaporanPeminjamanController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/peminjaman', LaporanPeminjamanController::class)->middleware('auth')->parameters([
                'peminjaman' => 'peminjaman:slug',
            ]);
            //end
            // laporan pengembalian
            Route::get('/laporan/pengembalian/checkSlug', [LaporanPengembalianController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/pengembalian/view-pdf', [LaporanPengembalianController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/pengembalian/download-pdf', [LaporanPengembalianController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/pengembalian', LaporanPengembalianController::class)->middleware('auth')->parameters([
                'pengembalian' => 'pengembalian:slug',
            ]);
            //end
            // laporan pemeliharaan
            Route::get('/laporan/pemeliharaan/checkSlug', [LaporanPemeliharaanController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/pemeliharaan/view-pdf', [LaporanPemeliharaanController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/pemeliharaan/download-pdf', [LaporanPemeliharaanController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/pemeliharaan', LaporanPemeliharaanController::class)->middleware('auth')->parameters([
                'pemeliharaan' => 'pemeliharaan:slug',
            ]);
            //end
            // laporan pemakaian
            Route::get('/laporan/pemakaian/checkSlug', [LaporanPemakaianController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/pemakaian/view-pdf', [LaporanPemakaianController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/pemakaian/download-pdf', [LaporanPemakaianController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/pemakaian', LaporanPemakaianController::class)->middleware('auth')->parameters([
                'pemakaian' => 'pemakaian:slug',
            ]);
            //end
            // laporan pemakaian barang habis pakai
            Route::get('/laporan/barangHabisPakai/checkSlug', [LaporanPemakaianBHPController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/barangHabisPakai/view-pdf', [LaporanPemakaianBHPController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/barangHabisPakai/download-pdf', [LaporanPemakaianBHPController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/barangHabisPakai', LaporanPemakaianBHPController::class)->middleware('auth')->parameters([
                'pemakaian' => 'pemakaian:slug',
            ]);
            //end



            //pencarian inventaris
            Route::get('/inventaris/checkSlug', [InventarisController::class, 'checkSlug'])->middleware('auth');
            Route::get('/inventaris/view-pdf', [InventarisController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/inventaris/download-pdf', [InventarisController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/inventaris', InventarisController::class)->middleware('auth')->parameters([
                'inventaris' => 'inventaris:slug',
            ]);

            //end
            //pencarian barang
            Route::get('/pencarian/barang/checkSlug', [PencarianBarangController::class, 'checkSlug'])->middleware('auth');
            Route::get('/pencarian/barang/view-pdf', [PencarianBarangController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/pencarian/barang/download-pdf', [PencarianBarangController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/pencarian/barang', PencarianBarangController::class)->middleware('auth')->parameters([
                'inventaris' => 'inventaris:slug',
            ]);
            //end
        });
    });

    Route::middleware('role:lurah')->group(function () {
        Route::prefix('lurah')->group(function () {

            Route::get('/dashboard', function () {
                return view('lurah.index');
            })->middleware('auth');
            Route::get('/dashboard', [InventarisController::class, 'dashboard_lurah'])->name('dashboard_lurah');

            // laporan Barang
            Route::get('/laporan/barang/checkSlug', [BarangController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/barang/view-pdf', [BarangController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/barang/download-pdf', [BarangController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/barang', BarangController::class)->middleware('auth')->parameters([
                'barang' => 'barang:slug',
            ]);
            //end
            // laporan Pengadaan Barang
            Route::get('/laporan/pengadaan/checkSlug', [Transaksi_pengadaanController::class, 'checkSlug'])->middleware('auth');
            Route::get('/laporan/pengadaan/view-pdf', [Transaksi_pengadaanController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/laporan/pengadaan/download-pdf', [Transaksi_pengadaanController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/laporan/pengadaan', Transaksi_pengadaanController::class)->middleware('auth')->parameters([
                'pengadaan' => 'pengadaan:slug',
            ]);
            //end

            //pencarian inventaris
            Route::get('/inventaris/checkSlug', [InventarisController::class, 'checkSlug'])->middleware('auth');
            Route::get('/inventaris/view-pdf', [InventarisController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/inventaris/download-pdf', [InventarisController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/inventaris', InventarisController::class)->middleware('auth')->parameters([
                'inventaris' => 'inventaris:slug',
            ]);
            //end
            //pencarian barang
            Route::get('/pencarian/barang/checkSlug', [PencarianBarangController::class, 'checkSlug'])->middleware('auth');
            Route::get('/pencarian/barang/view-pdf', [PencarianBarangController::class, 'viewPDF'])->name('view-pdf');
            Route::post('/pencarian/barang/download-pdf', [PencarianBarangController::class, 'downloadPDF'])->name('download-pdf');

            Route::resource('/pencarian/barang', PencarianBarangController::class)->middleware('auth')->parameters([
                'inventaris' => 'inventaris:slug',
            ]);
            //end
        });
    });
});

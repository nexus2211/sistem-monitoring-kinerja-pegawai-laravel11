<?php

use App\Http\Controllers\Admin\AttendancesController;
use App\Http\Controllers\Admin\BarcodeController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Admin\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('layout.app');
});


Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login/submit', [AuthController::class, 'loginSubmit'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::controller(PegawaiController::class)->group(function () {

    // PEGAWAI ROUTE
    Route::get('/pegawai','PegawaiIndex')->name('pegawai');
    Route::get('/pegawai/tambah','PegawaitampilTambah')->name('pegawai.tambah');
    Route::post('/pegawai/tambah','PegawaiStore')->name('pegawai.post');
    Route::get('/pegawai/edit/{id}', 'PegawaiEdit')->name('pegawai.edit');
    Route::put('/pegawai/edit/{id}', 'PegawaiUpdate')->name('pegawai.update');
    Route::delete('/pegawai/{id}','PegawaiDelete')->name('pegawai.delete');

    // JABATAN ROUTE
    Route::get('/jabatan','JabatanIndex')->name('jabatan');
    Route::post('/jabatan','JabatanStore')->name('jabatan.post');
    Route::delete('/jabatan/{id}','JabatanDelete')->name('jabatan.delete');
    Route::get('/jabatan/edit/{id}','JabatanEdit')->name('jabatan.edit');
    Route::put('/jabatan/edit/{id}','JabatanUpdate')->name('jabatan.update');

    // BAGIAN ROUTE
    Route::get('/bagian','BagianIndex')->name('bagian');
    Route::post('/bagian','BagianStore')->name('bagian.post');
    Route::delete('/bagian/{id}','BagianDelete')->name('bagian.delete');
    Route::get('/bagian/edit/{id}','BagianEdit')->name('bagian.edit');
    Route::put('/bagian/edit/{id}','BagianUpdate')->name('bagian.update');

    // SHIFT ROUTE
    Route::get('/shift','ShiftIndex')->name('shift');
    Route::post('/shift','ShiftStore')->name('shift.post');
    Route::delete('/shift/{id}','ShiftDelete')->name('shift.delete');
    Route::get('/shift/edit/{id}','ShiftEdit')->name('shift.edit');
    Route::put('/shift/edit/{id}','ShiftUpdate')->name('shift.update');

});

Route::get('/attendances/list', [AttendancesController::class, 'AttendanceInList'])->name('listAttendances');
Route::get('/attendances', [AttendancesController::class, 'AttendanceIn'])->name('attendances.in');
Route::post('/attendances', [AttendancesController::class, 'AttendanceInStore'])->name('attendances.inPost');
Route::get('/attendances/out', [AttendancesController::class, 'AttendanceOut'])->name('attendances.out');
Route::post('/attendances/out', [AttendancesController::class, 'AttendanceOutStore'])->name('attendances.outPost');
Route::post('/validasi', [AttendancesController::class, 'validasi'])->name('validasi');


Route::resource('barcode', BarcodeController::class);
Route::get('/download-qrcode}', [BarcodeController::class ,'downloadQr'])->name('barcode.download');
Route::get('/downloadAll-qrcode}', [BarcodeController::class ,'downloadAll'])->name('barcode.downloadAll');
// Route::get('/pegawai', [PegawaiController::class, 'PegawaiIndex'])->name('pegawai');

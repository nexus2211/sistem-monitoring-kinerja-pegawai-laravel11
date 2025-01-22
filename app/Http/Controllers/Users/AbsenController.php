<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use App\Models\shift;
use App\Models\pegawai;
use App\Models\attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function absenmasuk(){

        $currentDateTime = Carbon::today();
        $formattedDate = $currentDateTime->format('Y-m-d');
        $formattedTime = $currentDateTime->format('H:i:s');
        
        $userId = Auth::user()->id;

        //Ambil Pegawai
        $pegawaiId = pegawai::with('user','attendances')->where('user_id', $userId)->first();
        if ($pegawaiId) {
            $absen_hari_ini = $pegawaiId->attendances()->whereDate('date', $currentDateTime)->first();
            
        }
        // Status Absen Masuk
        $statusAbsenMasuk = $absen_hari_ini->status;
        $jamAbsenMasuk = $absen_hari_ini->waktu_masuk;
        $jamAbsenKeluar = $absen_hari_ini->waktu_keluar;
        // dd($jamAbsenMasuk);
    
        

        return view('user.absensi.absensimasuk', compact('statusAbsenMasuk','jamAbsenMasuk','jamAbsenKeluar'));
    }

    public function absenkeluar(){
        $currentDateTime = Carbon::today();
        $formattedDate = $currentDateTime->format('Y-m-d');
        $formattedTime = $currentDateTime->format('H:i:s');
        
        $userId = Auth::user()->id;

        //Ambil Pegawai
        $pegawaiId = pegawai::with('user','attendances')->where('user_id', $userId)->first();
        if ($pegawaiId) {
            $absen_hari_ini = $pegawaiId->attendances()->whereDate('date', $currentDateTime)->first();
            
        }
        // Status Absen Masuk
        $statusAbsenMasuk = $absen_hari_ini->status;
        $jamAbsenMasuk = $absen_hari_ini->waktu_masuk;
        $jamAbsenKeluar = $absen_hari_ini->waktu_keluar;
        // dd($jamAbsenMasuk);
    
        

        return view('user.absensi.absensikeluar', compact('statusAbsenMasuk','jamAbsenMasuk','jamAbsenKeluar'));
    }

    public function absenmasukStore(Request $request){
        $currentDateTime = Carbon::now();
        $formattedDate = $currentDateTime->format('Y-m-d');
        $formattedTime = $currentDateTime->format('H:i:s');
        $pegawaiId = $request->pegawai_id;

        $qr = $request->qr_code;

        // dd($qr);

        //Ambil Pegawai
        $pegawai = pegawai::with('user')->where('nip', $qr)->first();

        //QR dan auth pegawai
        if (Auth::check()) {
            $userId = Auth::user()->id;
            // $pegawaiId = $pegawai->id;
            $chekUser = $pegawai->user_id == $userId;
            if(!$chekUser){
                return redirect()->route('absen.masuk')->with('gagal','QR Code Tidak Sesuai!');
            }
        }

        // Cek apakah pegawai sudah absen pada hari ini
        $absen_hari_ini = attendance::where('pegawai_id', $pegawai->id ?? $pegawaiId)
            ->whereDate('date', $currentDateTime->toDateString())
            ->first();

        if ($absen_hari_ini) {
            return redirect()->route('absen.masuk')->with('gagal','Pegawai sudah absen hari ini!');
        }

        //Mengambil data pegawai dan shift
        $pegawaiShift = Pegawai::where('id', $pegawai->id ?? $pegawaiId)->value('shift_id');
        $shift = shift::where('id', $pegawaiShift)->first();

        //Parsin waktu menggunakan carbon
        $waktumulaiCarbon = Carbon::parse($shift->waktu_mulai);
        $waktuakhirCarbon = Carbon::parse($shift->waktu_akhir);

        //Menambahkan waktu lebih untuk waktu mulai absen
        $menitTelat = 15; //menit
        $waktumulaiTelat =  $waktumulaiCarbon->addMinutes($menitTelat)->toTimeString();

        if ($request->filled('status')) {
            $statusHadir = $request->status;
        }elseif($waktumulaiTelat <= $formattedTime && $formattedDate <= $waktuakhirCarbon){
            $statusHadir = 'late';
        }else if($waktumulaiTelat >= $formattedTime && $formattedDate <= $waktuakhirCarbon) {
            $statusHadir = 'present';
        }else{
            return redirect()->route('absen.masuk')->with('gagal','Diluar Jadwal Shift');
        }

        $data = [
            
            'pegawai_id' => $pegawai->id ?? $pegawaiId->id,
            'date' => $formattedDate,
            'waktu_masuk' => $formattedTime,
            'status' => $statusHadir,
            'note' => $request->note ?? null,
            'attachment' => null
        ];
        // dd($data);

        attendance::create($data);
        return redirect()->route('absen.masuk')->with('success','Pegawai Berhasil Absensi!');
        
    }

    public function absenkeluarStore(Request $request){

        $currentDateTime = Carbon::now();
        $formattedDate = $currentDateTime->format('Y-m-d');
        $formattedTime = $currentDateTime->format('H:i:s');
        

        $qr = $request->qr_code;

        // dd($qr);

        //Ambil Pegawai
        $pegawai = pegawai::with('user')->where('nip', $qr)->first();

        //QR dan auth pegawai
        if (Auth::check()) {
            $userId = Auth::user()->id;
            // $pegawaiId = $pegawai->id;
            $chekUser = $pegawai->user_id == $userId;
            if(!$chekUser){
                return redirect()->route('absen.keluar')->with('gagal','QR Code Tidak Sesuai!');
            }
        }

        // Cek apakah pegawai sudah absen pada hari ini
        $absen_hari_ini = attendance::where('pegawai_id', $pegawai->id)
            ->whereDate('date', $currentDateTime->toDateString())
            ->first();

            if ($absen_hari_ini == null) {
                return redirect()->route('absen.keluar')->with('gagal','Pegawai Belum Absen Hari Ini');
            }else if ($absen_hari_ini->waktu_keluar){
                return redirect()->route('absen.keluar')->with('gagal','Pegawai Sudah Absen Keluar');
            }

        //Mengambil data pegawai dan shift
        $pegawaiShift = Pegawai::where('id', $pegawai->id)->value('shift_id');
        $shift = shift::where('id', $pegawaiShift)->first();

        //Parsin waktu menggunakan carbon
        $waktumulaiCarbon = Carbon::parse($shift->waktu_mulai);
        $waktuakhirCarbon = Carbon::parse($shift->waktu_akhir);


        $data = [
            
            'waktu_keluar' => $formattedTime,
            
        ];
        // dd($data);

        attendance::where('pegawai_id', $pegawai->id)->update($data);
        return redirect()->route('absen.keluar')->with('success','Pegawai Berhasil Absensi!');
    }
}

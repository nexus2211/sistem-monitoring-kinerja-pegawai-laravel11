<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\pegawai;
use App\Models\shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendancesController extends Controller
{
    public function AttendanceIn() {

        $pegawai = Pegawai::all();
        $shift = Shift::all();

        
        return view('attendances.attendance' , compact('pegawai','shift'));
    }

    public function validasi(Request $request){

        // dd($request->all());
        $qr = $request->qr_code;
        $data = '6474765401146968'; 
        
        if($qr == $data){
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Melakukan Absensi'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Gagal Melakukan Absensi'
            ]);
        }
    }

    public function AttendanceInList() {

        $today = Carbon::today();
        $tglFormat =  Carbon::parse($today)->format('Y-m-d');

        //Mengambil data pegawai dan attendaces
        $attendances = Attendance::where('date', date('Y-m-d'))->get();
        // $pegawai = Pegawai::with('attendances' ,'jabatan','bagian','shift')->get();
        $pegawai = Pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->get();


        //Menghitung jumlah keterangan absen
        $pegawaiCount = $pegawai->count();
        $presentCount = $attendances->where('status' , 'present')->count();
        $lateCount = $attendances->where('status' , 'late')->count();
        $presentLateCount = $presentCount + $lateCount; 
        $excusedCount = $attendances->where('status' , 'excused')->count();
        $sickCount = $attendances->where('status' , 'sick')->count();
        $absentCount = $pegawaiCount - ($presentCount + $lateCount + $excusedCount + $sickCount);

        
    //    dd($pegawai11);
       
        return view('attendances.listattend', compact('pegawai','pegawaiCount','presentCount','presentLateCount','excusedCount','sickCount','lateCount','absentCount'));
    }

    public function AttendanceInStore(Request $request) {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
        $formattedDate = $currentDateTime->format('Y-m-d');
        $formattedTime = $currentDateTime->format('H:i:s');

        $qr = $request->qr_code;

        // Ambil pegawai
        $pegawaiInput = Pegawai::find($request->pegawai);
        $pegawai = Pegawai::where('nip', $qr)->first();


        // Cek apakah pegawai sudah absen pada hari ini
        $absen_hari_ini = Attendance::where('pegawai_id', $pegawai->id ?? $pegawaiInput->id)
            ->whereDate('date', $currentDateTime->toDateString())
            ->first();

            // dd($absen_hari_ini);

        if ($absen_hari_ini) {
            return redirect()->route('attendances.in')->with('gagal','Pegawai sudah absen hari ini!');
        }

        //Mengambil data pegawai dan shift
        $pegawaiShift = Pegawai::where('id', $pegawai->id ?? $pegawaiInput->id)->value('shift_id');
        $shift = Shift::where('id', $pegawaiShift)->first();
        

        //Parsin waktu menggunakan carbon
        $waktumulaiCarbon = Carbon::parse($shift->waktu_mulai);
        $waktuakhirCarbon = Carbon::parse($shift->waktu_akhir);

        //Menambahkan waktu lebih untuk waktu mulai absen
        $menitTelat = 15; //menit
        $waktumulaiTelat =  $waktumulaiCarbon->addMinutes($menitTelat)->toTimeString();

       

        if($waktumulaiTelat <= $formattedTime && $formattedDate <= $waktuakhirCarbon){
            $statusHadir = 'late';
        }else if($waktumulaiTelat >= $formattedTime && $formattedDate <= $waktuakhirCarbon) {
            $statusHadir = 'present';
        }else {
            // $statusHadir = 'absent';
            return redirect()->route('attendances.in')->with('gagal','Diluar Jadwal Shift Pegawai');
        }

        $data = [
            
            'pegawai_id' => $pegawai->id ?? $pegawaiInput->id,
            'date' => $formattedDate,
            'waktu_masuk' => $formattedTime,
            'status' => $statusHadir,
            'note' => $request->note ?? null,
            'attachment' => null
        ];

        // dd($absen_hari_ini);

        attendance::create($data);
        return redirect()->route('attendances.in')->with('success','Pegawai Berhasil Absensi!');
        
    }
}

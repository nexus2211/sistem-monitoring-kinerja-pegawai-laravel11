<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\shift;
use App\Models\pegawai;
use App\Models\attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\bagian;
use App\Models\jabatan;

class AttendancesController extends Controller
{
    //ABSENSI MASUK
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
        //Pegawai Paginate
        $pegawai = Pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->paginate(10);

        //Count Pegawai
        $pegawaiData = Pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->get();


        //Menghitung jumlah keterangan absen
        $pegawaiCount = $pegawaiData->count();
        $presentCount = $attendances->where('status' , 'present')->count();
        $lateCount = $attendances->where('status' , 'late')->count();
        $presentLateCount = $presentCount + $lateCount; 
        $excusedCount = $attendances->where('status' , 'excused')->count();
        $sickCount = $attendances->where('status' , 'sick')->count();
        $absentCount = $pegawaiCount - ($presentCount + $lateCount + $excusedCount + $sickCount);

        

       
        return view('attendances.listattend', compact('pegawai','pegawaiCount','presentCount','presentLateCount','excusedCount','sickCount','lateCount','absentCount'));
    }

    public function AttendancesDetail(Request $request) {

        // Mendapatkan tanggal awal dan akhir minggu ini
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $search = $request->input('cari_pegawai');
        $jabatanFilter = $request->input('jabatan');
        $bagianFilter = $request->input('bagian');

        // minggu ini
        $data = [];
        for ($i = 0; $i < 7; $i++) {
            $data[] = $startOfWeek->copy()->addDays($i)->format('d/m');
        }

        // Mendapatkan tanggal awal dan akhir Bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Bulan ini
        $dataMonth = [];
        for ($i = 0; $i < 31; $i++) {
            $dataMonth[] = $startOfMonth->copy()->addDays($i)->format('d/m');
        }


        //Query Database
        $pegawai = Pegawai::with(['attendances' => function($query) use ($startOfWeek,$endOfWeek){
            $query->whereBetween('date', [$startOfWeek->format('Y-m-d'),$endOfWeek->format('Y-m-d')]);
        },'jabatan','bagian','shift'])->when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")
            ->orWhere('nip','like',"%{$search}%");
        })->when($jabatanFilter, function($query) use ($jabatanFilter) {
            return $query->where('jabatan_id', $jabatanFilter); // Ganti 'jabatan_id' dengan nama kolom yang sesuai
        })->when($bagianFilter, function($query) use ($bagianFilter) {
            return $query->where('bagian_id', $bagianFilter); // Ganti 'jabatan_id' dengan nama kolom yang sesuai
        })->paginate(5);

        $jabatan = jabatan::all();
        $bagian = bagian::all();

        // Mengonversi status absensi ke format d/m
        foreach ($pegawai as $dataP) {
            foreach ($dataP->attendances as $attendance) {
                $attendance->formatted_date = Carbon::parse($attendance->date)->format('d/m');
            }

        }

       
        return view('attendances.reportAttend.detailAttendWeek', compact('data','pegawai','jabatan','bagian','dataMonth'));
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

        if ($request->filled('status')) {
            $statusHadir = $request->status;
        }elseif($waktumulaiTelat <= $formattedTime && $formattedDate <= $waktuakhirCarbon){
            $statusHadir = 'late';
        }else if($waktumulaiTelat >= $formattedTime && $formattedDate <= $waktuakhirCarbon) {
            $statusHadir = 'present';
        }else{
            return redirect()->route('attendances.in')->with('gagal','Diluar Jadwal Shift Pegawai');
        }

        

        // dd($statusHadir);
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

    // ABSENSI KELUAR
    public function AttendanceOut(Request $request) {

        $search = $request->input('cari_pegawai');
        $today = Carbon::today();
        $tglFormat =  Carbon::parse($today)->format('Y-m-d');

        //Mengambil data pegawai dan attendaces
        $attendances = Attendance::where('date', date('Y-m-d'))->get();
        $pegawai = Pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")
            ->orWhere('nip','like',"%{$search}%");
        })->paginate(5);

        
        
        return view('attendances.attendanceout' , compact('pegawai'));
    }

    public function AttendanceOutStore(Request $request) {
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

        

        if ($absen_hari_ini == null) {
            return redirect()->route('attendances.out')->with('gagal','Pegawai Belum Absen Hari Ini');
        }else if ($absen_hari_ini->waktu_keluar){
            return redirect()->route('attendances.out')->with('gagal','Pegawai Sudah Absen Keluar');
        }

        

        //Mengambil data pegawai dan shift
        $pegawaiShift = Pegawai::where('id', $pegawai->id ?? $pegawaiInput->id)->value('shift_id');
        $shift = Shift::where('id', $pegawaiShift)->first();
        

        //Parsin waktu menggunakan carbon
        $waktumulaiCarbon = Carbon::parse($shift->waktu_mulai);
        $waktuakhirCarbon = Carbon::parse($shift->waktu_akhir);

        //Menambahkan waktu lebih untuk waktu mulai absen
        // $menitTelat = 15; //menit
        // $waktumulaiTelat =  $waktumulaiCarbon->addMinutes($menitTelat)->toTimeString();

        // if($waktumulaiTelat <= $formattedTime && $formattedDate <= $waktuakhirCarbon){
        //     $statusHadir = 'late';
        // }else if($waktumulaiTelat >= $formattedTime && $formattedDate <= $waktuakhirCarbon) {
        //     $statusHadir = 'present';
        // }else {
        //     // $statusHadir = 'absent';
        //     return redirect()->route('attendances.out')->with('gagal','Diluar Jadwal Shift Pegawai');
        // }

        $data = [
            
            
            'waktu_keluar' => $formattedTime,
            
        ];

        // dd($pegawai->id);

        attendance::where('pegawai_id', $pegawai->id)->update($data);
        return redirect()->route('attendances.out')->with('success','Absensi Keluar Berhasil');
        
    }
}

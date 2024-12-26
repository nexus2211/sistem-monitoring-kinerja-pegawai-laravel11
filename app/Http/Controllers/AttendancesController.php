<?php

namespace App\Http\Controllers;

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

    public function AttendanceInList() {

        // $attendances = attendance::with(['pegawai'])->get();
        $attendances = Attendance::get();
        $pegawai = Pegawai::with('attendances','jabatan','bagian','shift')->get();
        $pegawaiCount = $pegawai->count();
        $presentCount = $attendances->where('status' , 'present')->count();
        $excusedCount = $attendances->where('status' , 'excused')->count();
        $sickCount = $attendances->where('status' , 'sick')->count();
        $absentCount = $pegawaiCount - ($presentCount + $excusedCount + $sickCount);
    //   dd($absentCount);
       
        return view('attendances.listattend', compact('pegawai','pegawaiCount','presentCount','excusedCount','sickCount','absentCount'));
    }

    public function AttendanceInStore(Request $request) {
        $currentDateTime = now();
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
        $formattedDate = $currentDateTime->format('Y-m-d');
        $formattedTime = $currentDateTime->format('H:i:s');


        $data = [
            
            'pegawai_id' => $request->pegawai,
            'date' => $formattedDate,
            'waktu_masuk' => $formattedTime,
            'status' => $request->status,
            'note' => $request->note,
            'attachment' => $request->lampiran
        ];

        // dd($data);

        attendance::create($data);
        return redirect()->route('attendances.in');
    }
}

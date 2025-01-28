<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use App\Models\pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailAbsenController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $userId = Auth::user()->id;
        // dd($userId);
        return view('user.absensi.detailabsenpegawai');
    }

    public function getAbsensi() {
        $events = [];
        $tanggalMulai = '2025-01-01';
        $tanggalAkhir = '2025-12-31';
        $userId = Auth::user()->id;
        
        // $absensi = pegawai::with('attendances')->find($pegawaiId);
        $absensi = pegawai::with('attendances')->where('user_id', $userId)->first();

        if ($absensi) {
            $range = Carbon::parse($tanggalMulai)->daysUntil($tanggalAkhir);
            $existingDates = [];
            foreach ($absensi->attendances as $dataA) {
                $startDateTime = $dataA->date . ' ' . $dataA->waktu_masuk;
                $endDateTime = $dataA->date . ' ' . $dataA->waktu_keluar;               
                $events[] = [      
                    'title' => $dataA->status,      
                    'start' => $startDateTime,      
                    'end' => $endDateTime,
                        
                ];
                // $existingDates[] = $dataA->date;      
            }
            
           
        }

        return response()->json($events);
    }
}

 // foreach ($range as $date) {
            //     if (!in_array($date->toDateString(), $existingDates)) {
            //         $events[] = [     
            //             'title' => $absensi->status . 'Absen',        
            //             'start' => $date->toDateString() . ' 00:00:00', // Atur waktu sesuai kebutuhan      
            //             'end' => $date->toDateString() . ' 23:59:59', // Atur waktu sesuai kebutuhan      
                        
            //         ];
            //     } 
            // }
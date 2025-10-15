<?php

namespace App\Http\Controllers\Users;

use App\Models\sop;
use App\Models\pegawai;
use App\Models\pegawaiTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    public function index(){
        $userId = Auth::user()->id;
        $status = '';
        $pending = 'pending';
        $proses = 'process';
        $done = 'done';

        $pegawai = pegawai::with('bagian')->where('user_id', $userId)->first();
        $sop = sop::where('bagian_id', $pegawai->bagian->id)->count();

        $task = pegawaiTask::with('pegawai', 'task')
        ->when($status, function($query, $status) {
            // Filter status
            return $query->where('status', $status);
        })->where('status', '!=', 'done')
        ->whereHas('pegawai', function($query) use ($userId) {
            // Filter user_id
            $query->where('pegawai.user_id', $userId);
        })
        ->get();

        $allCount = pegawaiTask::with('pegawai', 'task')
        ->when($status, function($query, $status) {
            // Filter berdasarkan status jika ada
            return $query->where('status', $status);
        })
        ->whereHas('pegawai', function($query) use ($userId) {
            $query->where('pegawai.user_id', $userId);
        })->count();

        $pendingCount = pegawaiTask::with('pegawai', 'task')
        ->when($pending, function ($query, $pending) { 
            return $query->where('status', $pending); 
        })
        ->when($userId, function($query, $userId) {
            return $query->whereHas('pegawai', function ($query) use ($userId) {
                $query->where('pegawai.user_id', $userId);
            });
        })
        ->count();

        $prosesCount = pegawaiTask::with('pegawai', 'task')
        ->when($proses, function ($query, $proses) { 
            return $query->where('status', $proses); 
        })
        ->when($userId, function($query, $userId) {
            return $query->whereHas('pegawai', function ($query) use ($userId) {
                $query->where('pegawai.user_id', $userId);
            });
        })
        ->count();

        $totalProses = $pendingCount + $prosesCount;

        $doneCount = pegawaiTask::with('pegawai', 'task')
        ->when($done, function ($query, $done) { 
            return $query->where('status', $done); 
        })
        ->when($userId, function($query, $userId) {
            return $query->whereHas('pegawai', function ($query) use ($userId) {
                $query->where('pegawai.user_id', $userId);
            });
        })
        ->count();

        return view('user.home', compact('allCount','totalProses','doneCount','sop','task','pegawai'));
    }

    public function downloadQr(Request $request){
        $userId = Auth::user()->id;
        $pegawai_id = pegawai::with('bagian')->where('user_id', $userId)->first();     
        $qrCode = QrCode::format('png')->size(500)->margin(2)->generate($pegawai_id->nip);
        $filename = 'qrcode_'. $pegawai_id->nip . '_' . $pegawai_id->nama_pegawai . '.png';   
     
         // Mengembalikan response dengan file QR Code
         return Response::make($qrCode, 200, [
             'Content-Type' => 'image/png',
             'Content-Disposition' => 'attachment; filename="' . $filename . '"'
         ]);
     }
}

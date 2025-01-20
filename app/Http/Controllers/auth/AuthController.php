<?php

namespace App\Http\Controllers\auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\pegawai;
use App\Models\attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\sop;
use App\Models\task;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerView() {

        return view('auth.register');
    }

    public function register(Request $request) {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'type' => $request->input('type')
        ];

        User::create($data);
        return redirect()->route('login')->with('success','Data berhasil disimpan!');
    }

    public function loginView() {

        return view('auth.login');
    }

    public function loginSubmit(Request $request) {
        $data = $request->only('email','password');

        if(Auth::attempt($data)){
            $request->session()->regenerate();
            return redirect()->route('pegawai');
        }else {
            return redirect()->route('login')->with('gagal','Email atau Password salah');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboardAdmin(){

        $today = Carbon::today();
        $tglFormat =  Carbon::parse($today)->format('Y-m-d');

        // Memanggil Data Untuk Card Stastistic
        $pegawaiData = pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->get();
        //Pegawai Paginate
        $pegawai = Pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->latest()->paginate(5);

        $attendances = attendance::where('date', date('Y-m-d'))->get();
        $sop = sop::get();
        $task = task::paginate(5);
        // $task = pegawai::with('tasks')->get();
        // $taskCount = 0;
        // foreach ($task as $data) {
        //     foreach ($data->tasks as $tugas) {
        //         $taskData = $tugas->tugas;
        //         ++$taskCount;
        //     }
        // }

        // Dashboard card
        $pegawaiCount = $pegawaiData->count();
        $absenToday = $attendances->where('status' , 'present')->count();
        
        $lateCount = $attendances->where('status' , 'late')->count();
        $presentLateCount = $absenToday + $lateCount; 
        $excusedCount = $attendances->where('status' , 'excused')->count();
        $sickCount = $attendances->where('status' , 'sick')->count();
        $absentCount = $pegawaiCount - ($absenToday + $lateCount + $excusedCount + $sickCount);
        
        $sopCount = $sop->count();
        $taskCount = $task->count();


        return view('welcome', compact('pegawaiCount','presentLateCount','taskCount','sopCount','pegawai','task','excusedCount','sickCount','absentCount'));
    }
}

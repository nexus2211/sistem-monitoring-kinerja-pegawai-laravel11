<?php

namespace App\Http\Controllers\Users;

use App\Models\task;
use App\Models\pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\pegawaiTask;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    public function index(){
        $userId = Auth::user()->id;
        $pegawai = pegawai::with('tasks','bagian')->where('user_id', $userId)->first();

        // foreach ($pegawai->tasks as $data) {
        //     $pivotId = $data->pivot->id;
        // }
       
        
    
        return view('user.task.task', compact('pegawai'));
    }

    public function detailTask($id){
        $userId = Auth::user()->id;
        $pegawaitask = pegawaiTask::with('pegawai','task')->find($id);
        $sop = $pegawaitask->task->sop->title;
        
        
        
        return view('user.task.detailTask', compact('pegawaitask','sop'));
        
    }
}

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

    public function statusTask(Request $request, string $id){
        // dd($request->all());

        $request->validate([
            'statusTask'  => 'required',
            'buktiFile' => 'file|mimes:jpg,jpeg,png,pdf|max:5048',
            
        ],[
            'statusTask.required'=>'Pilih Status',
            'max'=>'File Maksimal 5 MB',
        ]);

        $title = str_replace(' ', '', $request->titleTask);
        $status = $request->statusTask;

        if($status === 'done'){
            $request->validate([
                'buktiFile' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5048',
                
            ],[
                'buktiFile.required'=>'Upload File Bukti Terlebih Dahulu',
                'max'=>'File Maksimal 5 MB',
            ]);
        }

        
        // File
        if ($request->hasFile('buktiFile')) {
            $file = $request->file('buktiFile');
            $fileNameOrigin = $file->getClientOriginalName();
            $cleaned_name = str_replace(' ', '_', $fileNameOrigin);
            $file_name = time()."_". "$title" ."_".$cleaned_name;
            $destination_path = public_path('bukti');
            $file->move($destination_path, $file_name);
    
        }

        // dd($request->file('buktiFile'));

        
        $data = [
            'status' => $status,
            'bukti' => isset($file_name)?$file_name:null,
        ];

        // dd($data);
        pegawaiTask::where('id', $id)->update($data);

        return redirect()->route('usertask.index');
    }

    public function buktiTask($id){
        // $userId = Auth::user()->id;
        $pegawaitask = pegawaiTask::with('pegawai','task')->find($id);
        $buktiPath = public_path('bukti')."/".$pegawaitask->bukti;
    
        // dd($buktiPath);

        return view('user.task.buktiTask', compact('pegawaitask', 'buktiPath'));
    }
}

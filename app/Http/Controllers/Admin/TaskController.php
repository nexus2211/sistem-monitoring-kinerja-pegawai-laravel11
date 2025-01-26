<?php

namespace App\Http\Controllers\Admin;

use App\Models\sop;
use App\Models\task;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use App\Models\pegawaiTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index(Request $request){

        // dd($request->all());

        $bagianFilter = $request->input('bagian');
        $jabatanFilter = $request->input('jabatan');
        $search = $request->input('cari_pegawai');
        $status = $request->input('status');
        
        
        $bagian = bagian::get();
        $jabatan = jabatan::get();
        // $pegawai = pegawai::with(['tasks','bagian'])
        
        // $pegawai = pegawai::with('tasks','bagian')
        // ->when($search, function($query, $search){
        //     return $query->where('nama_pegawai','like',"%{$search}%")
        //     ->orWhere('nip','like',"%{$search}%");
        // })->when($bagianFilter, function($query, $bagianFilter){
        //     return $query->where('bagian_id', $bagianFilter);
        // })->when($jabatanFilter, function($query, $jabatanFilter){
        //     return $query->where('jabatan_id', $jabatanFilter);
        // })->when($status, function($query, $status) {
        //     return $query->whereHas('tasks', function($query) use ($status) {
        //         $query->where('pegawai_task.status' , $status);
        //     });
        // })
        // ->paginate(10);

        $pegawai = pegawaiTask::with('pegawai', 'task') 
        ->when($search, function ($query, $search) {
            return $query->whereHas('pegawai', function ($query) use ($search) {
                $query->where('nama_pegawai', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        })
        ->when($bagianFilter, function ($query, $bagianFilter) {
            return $query->whereHas('pegawai', function ($query) use ($bagianFilter) {
                $query->where('bagian_id', $bagianFilter);
            });
        })
        ->when($jabatanFilter, function ($query, $jabatanFilter) {
            return $query->whereHas('pegawai', function ($query) use ($jabatanFilter) {
                $query->where('jabatan_id', $jabatanFilter);
            });
        })
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->paginate(10);

        $statusCount = pegawaiTask::with('pegawai', 'task')->count();

        $pendingCount = pegawaiTask::with('pegawai', 'task')
        ->whereHas('pegawai', function($query) {
            $query->where('status', 'pending');
        })->count();

        $processCount = pegawaiTask::with('pegawai', 'task')
        ->whereHas('pegawai', function($query) {
            $query->where('status', 'process');
        })->count();

        $doneCount = pegawaiTask::with('pegawai', 'task')
        ->whereHas('pegawai', function($query) {
            $query->where('status', 'done');
        })->count();
    


    //    dd($statusCount);
        

        return view('admin.task.task', compact('pegawai','bagian','jabatan','statusCount','pendingCount','processCount','doneCount'));
    }


    public function create(Request $request){

        $bagian = bagian::get();
        $sop = sop::with('bagian')->get();

        $bagianData = $request->bagianInput2;
        
        

        $task = task::with('bagian','sop')
        ->whereHas('bagian', function($query) use ($bagianData) {
            return $query->where('id', $bagianData);
        })->get();

        $pegawai = pegawai::with('bagian','jabatan','shift')
        ->whereHas('bagian', function($query) use ($bagianData) {
            return $query->where('id', $bagianData);
        })
        ->get();

        return view('admin.task.tambah', compact('bagian','sop','task','pegawai'));

    }

    public function store(Request $request){

        $request->validate([
            'tugasInput'  => 'required|min:3|max:30',
            'descInput'  => 'required|min:3|max:50',
            'sopInput'  => 'required',
            'bagianInput'  => 'required',
            'mulaiInput'  => 'required',
            'deadlineInput'  => 'required',
            
        ],[
            'tugasInput.required'=>'Title wajib diisi',
            'descInput.required'=>'Deskripsi wajib diisi',
            'bagianInput.required'=>'Pilih Bagian Terlebih Dahulu',
            'sopInput.required'=>'Pilih SOP Terlebih Dahulu',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input karakter terlalu panjang',
        ]);

        $data = [
            'tugas' => $request->tugasInput,
            'desc' => $request->descInput,
            'sop_id' => $request->sopInput,
            'bagian_id' => $request->bagianInput,
            'waktu_mulai' => $request->mulaiInput,
            'waktu_deadline' => $request->deadlineInput,
            
        ];

        $taskStore = task::create($data);

        // dd($data);

        return redirect()->route('task.create');
    }

    public function edit($id){
        $task = task::find($id);
        $bagian = bagian::get();
        $sop = sop::with('bagian')->get();

        

        return view('admin.task.edit', compact('bagian','sop','task'));
    }

    public function update(Request $request, string $id){
        $request->validate([
            'tugasInput'  => 'required|min:3|max:30',
            'descInput'  => 'required|min:3|max:50',
            'sopInput'  => 'required',
            'bagianInput'  => 'required',
            'mulaiInput'  => 'required',
            'deadlineInput'  => 'required',
            
        ],[
            'tugasInput.required'=>'Title wajib diisi',
            'descInput.required'=>'Deskripsi wajib diisi',
            'bagianInput.required'=>'Pilih Bagian Terlebih Dahulu',
            'sopInput.required'=>'Pilih SOP Terlebih Dahulu',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input karakter terlalu panjang',
        ]);

        $data = [
            'tugas' => $request->tugasInput,
            'desc' => $request->descInput,
            'sop_id' => $request->sopInput,
            'bagian_id' => $request->bagianInput,
            'waktu_mulai' => $request->mulaiInput,
            'waktu_deadline' => $request->deadlineInput,
            
        ];

        // dd($data);

        task::where('id', $id)->update($data);

        return redirect()->route('task.create');
    }


    public function destroy(string $id){
        // dd($request->all());
        task::where('id', $id)->delete();
        return redirect()->route('task.create');
    }

    public function detailTask($id){
        $task = task::find($id);
        $sop = $task->sop->title;
        // dd($sop);
        return view('admin.task.detail', compact('task','sop'));
        
    }

    public function storePegawai(Request $request){
        // dd($request->all());
        
        $request->validate([
            'tasks'  => 'required',
            'pegawaiInput'  => 'required',
        
        ],[
            'tasks.required'=>'Pilih Tugas Terlebih Dahulu',
            'pegawaiInput.required'=>'Pilih Pegawai Yang Ingin Di Beri Tugas',
            
        ]);
        
        $pegawaiIdd = $request->pegawaiInput;
        $tugas = $request->tasks;
        

        $pegawaiId = pegawai::with('jabatan','bagian','shift')->findMany($request->pegawaiInput);
        
        // dd($pegawaiId);
        // $pegawaiId->tasks()->sync($tugas); // Pastikan menggunakan 'tasks()'
        foreach ($pegawaiId as $pegawai) {
            
            // $pegawai->tasks()->attach($tugas);
            $pegawai->tasks()->syncWithoutDetaching($tugas);
        }
        
        // dd($pegawaiId);

        return redirect()->route('task.create');
    }
}

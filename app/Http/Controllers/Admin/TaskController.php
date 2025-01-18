<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bagian;
use App\Models\pegawai;
use App\Models\sop;
use App\Models\task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){

        
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

        return view('task.tambah', compact('bagian','sop','task','pegawai'));

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
            $pegawai->tasks()->sync($tugas);
        }
        
        // dd($pegawaiId);

        return redirect()->route('task.create');
    }
}

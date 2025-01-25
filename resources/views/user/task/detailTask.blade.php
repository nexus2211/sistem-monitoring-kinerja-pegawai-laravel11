@extends('layout.app')
@section('konten-title', 'Data Task')

@section('konten-header')
    <div class="section-header">
        <h1>Detail Task</h1>
    </div>
@endsection

@section('konten-main')
    <div>
        <div class="card card-primary">
            <card class="card-header">
                <h4>Detail Tugas {{ $pegawaitask->task->tugas }}</h4>
            </card>
            <card class="card-body">

                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Penanggung Jawab Tugas : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $pegawaitask->pegawai->nama_pegawai }}</strong> 
                    </div>        
                </div>

                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Status Tugas : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong><div class="badge {{ $pegawaitask->status === 'pending' ? 'badge-warning' : ($pegawaitask->status === 'prosess' ? 'badge-info' : ($pegawaitask->status === 'done' ? 'badge-success' : ''))}}">{{ $pegawaitask->status }}</div></strong> 
                    </div>        
                </div>

                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Deskripsi Tugas : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $pegawaitask->task->desc }}</strong> 
                    </div>        
                </div>
    
                {{-- <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tugas Untuk Bagian : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong class="badge badge-info">{{ $task->bagian->bagian }}</strong> 
                    </div>        
                </div> --}}

                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tugas Untuk Periode : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong><div class="badge badge-success">{{ $pegawaitask->task->waktu_mulai }} - {{ $pegawaitask->task->waktu_deadline }}</div></strong> 
                    </div>        
                </div>
    
                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tanggal DiBuat : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $pegawaitask->task->created_at }}</strong> 
                    </div>        
                </div>
    
                <div class=" mb-4 row">
                    <div class="container d-flex">
                        <a href="{{ route('sop.pdf', $sop) }}" class="btn btn-outline-danger me-3 mr-2" target="_blank"><i class="fa fas fa-file-pdf"></i> Lihat SOP</a>

                        
                    </div>
                </div>

                <div class=" mb-3 row">
                    <div class="container d-flex">
                        
                        
                        <a href="{{ route('usertask.index') }}" class="btn btn-success me-3 mr-2"> Kembali</a>

                        <a href="{{ route('sop.pdf', $sop) }}" class="btn btn-primary me-3 mr-2" target="_blank"><i class="fa fas fa-save"></i> Simpan</a>
                    </div>
                </div>
            </card>
        </div>
    </div>
@endsection
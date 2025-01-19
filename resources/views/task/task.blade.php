@extends('layout.app')

@section('konten-header')
<div class="section-header">
    <h1>List Tugas</h1>
</div>
@endsection

@section('konten-main')

    <div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>List Tugas</h4>
                <div class="card-header-action">
                    <a href="{{ route('task.create') }}" class="btn btn-success mr-2"><i class="fa fas fa-plus"></i> Tambah Data</a>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <form action="#" method="get">
                        <H5>Filter : </H5>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="role" class="col-form-label">Cari Pegawai : </label>
                                    <input type="text" class="form-control" name="cari_pegawai">
                                </div>
                                <div class="col-sm-3">
                                    <label for="jabatan" class="col-form-label">Jabatan</label>
                                    <div class="input-group mb-3">
                                    <select class="custom-select form-control" name="jabatan">
                                        <option selected disabled>Jabatan</option>
                                        @foreach($jabatan as $data_jabatan)
                                            <option value="{{ $data_jabatan->id }}">{{ $data_jabatan->jabatan }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="bagian" class="col-form-label">Bagian</label>
                                    <select class="custom-select form-control" name="bagian">
                                    <option selected disabled>Bagian</option>
                                        @foreach($bagian as $data_bagian)
                                        <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                                        @endforeach
                                </select>
                                </div>

                                <div class="col-sm-2" >
                                    <label for="btnfilter" class="col-form-label">&nbsp;</label>
                                    <button class="btn btn-info form-control" name="btnfilter"><i class="fa fas fa-filter"></i> Filter</button>
                                </div>
                                {{-- style="margin-top: 40px;" --}}
                            </div>
                    </form>
                </div>


                <div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>Bagian</th>
                                    <th>Nama Tugas</th>
                                    <th>Status</th>
                                    <th>Waktu Mulai Tugas</th>
                                    <th>Deadline</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pegawai as $no=>$data) 
                                    @foreach ($data->tasks as $taskData)    
                                        <tr>
                                            <td class="text-center">{{ $no+1 }}</td>
                                            <td>{{ $data->nip }}</td>
                                            <td>{{ $data->nama_pegawai }}</td>
                                            <td>{{ $data->bagian->bagian }}</td>
                                            <td>{{ $taskData->tugas }}</td>
                                            <td><div class="badge badge-warning">{{ $taskData->pivot->status }}</div></td>
                                            <td><div class="badge badge-info">{{ $taskData->waktu_mulai }}</div></td>
                                            <td><div class="badge badge-info">{{ $taskData->waktu_deadline }}</div></td>
                                            <td><a href="" class="btn btn-sm btn-primary">Detail</a></td>
                                        </tr>                                  
                                    @endforeach                  
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
@endsection
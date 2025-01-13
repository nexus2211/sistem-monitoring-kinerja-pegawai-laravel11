@extends('layout.app')

@section('konten-header')
    <div class="section-header">
        <h1>Manage Akun</h1>
    </div>
@endsection

@section('konten-main')

    <div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Manage Akun Pegawai</h4>
                <div class="card-header-action">
                    <form action="#" method="get">
                        <div class="input-group" >
                            <input name="cari_pegawai" type="text" placeholder="Cari Pegawai" class="form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-primary">
                                    <i class="fa fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <form action="#" method="get">
                        <H5>Filter : </H5>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="nip" class="col-form-label">Role Akun </label>
                                    <select class="custom-select form-control" name="weekInputs" id="week">
                                        <option selected disabled>Tipe Akun</option>
                                        @foreach($uniqueTypes as $data)
                                                <option value="{{ $data }}">{{ $data }}</option>
                                        @endforeach
                                    </select>
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
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>jabatan</th>
                                    <th>Bagian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataUser as $no=>$data)    
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $data->user->email }}</td>
                                        <td>{{ $data->user->type }}</td>
                                        <td>{{ $data->nip }}</td>
                                        <td>{{ $data->nama_pegawai }}</td>
                                        <td>{{ $data->jabatan->jabatan }}</td>
                                        <td>{{ $data->bagian->bagian }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
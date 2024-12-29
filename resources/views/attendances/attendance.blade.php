@extends('layout.app')

@section('title-body', 'Attendances')

@push('styles')

@endpush


@section('konten-main')

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Scan Barcode</h4>
            </div>
            <div class="card-body">
                <label for="">Shift</label>
                        <div class="input-group mb-3">
                        <select class="form-control" name="shift" required>
                            <option selected disabled>Pilih Shift.</option>
                            @foreach ($shift as $data)
                            <option value="{{ $data->id }}">{{ $data->shift }} | {{ $data->waktu_mulai }} - {{ $data->waktu_akhir }} </option>
                            @endforeach
                                 
                        </select>
                </div>
                <div>
                    <button class="btn btn-success mt-2"><i class="fa fa-reguler fa-envelope-open-text"></i>  Ajukan Izin</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Detail Absensi</h4>
            </div>
            <div class="card-body">
                @if (session('gagal'))
                <div class="alert alert-danger">
                    <h5>{{ session('gagal') }}</h4>
                </div>
                @elseif (session('success'))
                <div class="alert alert-success">
                    <h5>{{ session('success') }}</h4>
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('attendances.inPost') }}" method="post">
                    @csrf
                    <label for="">Pegawai</label>
                        <div class="input-group mb-3">
                        <select class="form-control" name="pegawai" required>
                            <option selected disabled>Pilih Pegawai.</option>
                            @foreach ($pegawai as $data)
                            <option value="{{ $data->id }}">{{ $data->nama_pegawai }}</option>
                            @endforeach
                                 
                        </select>
                        
                    </div>

                    <label for="">Status</label>
                        <div class="input-group mb-3">
                        <select class="form-control" name="status" required>
                            <option selected disabled>Pilih Status..</option>
                      
                            <option value="present">Hadir</option>
                            <option value="late">Telat</option>
                            <option value="excused">Izin</option>
                            <option value="sick">Sakit</option>
                            <option value="absent">Absen</option>
                              
                        </select>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="fa fas fa-compress-arrows-alt""></i>
                                </div>
                                <div class="card-warp">
                                    <div class="card-header">Absen Masuk</div>
                                    <div class="card-body"><h5>Belum Absen</h5></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-warning">
                                    <i class="fa fas fa-expand-arrows-alt"></i>
                                </div>
                                <div class="card-warp">
                                    <div class="card-header">Absen Keluar</div>
                                    <div class="card-body"><h5>Belum Absen</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">

                        <button class="btn btn-primary mt-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@push('scripts')

@endpush
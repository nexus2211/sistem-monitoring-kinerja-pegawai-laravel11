@extends('layout.app')

@push('style')
  

@endpush

@section('konten-header')
<div class="section-header">
    <h1>Rekap Data dan Import/Export</h1>
</div>

@endsection

@section('konten-main')

    <div class="container">
        <h2 class="section-title">Absensi</h2>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <a href="{{ route('listAttendances') }}" class="card card-statistic-1"> 
                    <div class="card-icon shadow-primary bg-success"><i class="fa fas fa-calendar-day"></i></div>
                    <div class="card-warp">
                        <div class="card-header"><h4>Rekap Data Absensi</h4></div>
                        <div class="card-body">Absensi Harian</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4">
                <a href="{{ route('detailAttendances') }}" class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-success"><i class="fa fas fa-calendar-week"></i></div>
                    <div class="card-warp">
                        <div class="card-header"><h4>Rekap Data Absensi</h4></div>
                        <div class="card-body">Absensi Mingguan</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4">
                <a href="{{ route('detailAttendancesMonth') }}" class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-success"><i class="fa fas fa-calendar-alt"></i></div>
                    <div class="card-warp">
                        <div class="card-header"><h4>Rekap Data Absensi</h4></div>
                        <div class="card-body">Absensi Bulanan</div>
                    </div>
                </a>
            </div>
        </div>

        <h2 class="section-title">Pegawai</h2>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <a href="{{ route('export-pegawai') }}" class="card card-statistic-1"> 
                    <div class="card-icon shadow-primary bg-info"><i class="fa fas fa-user"></i></div>
                    <div class="card-warp">
                        <div class="card-header"><h4>Rekap Data Pegawai</h4></div>
                        <div class="card-body">PDF Pegawai</div>
                    </div>
                </a>
            </div>
        </div>

    </div>

@endsection

@push('script')

@endpush
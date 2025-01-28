@extends('layout.app')

@section('konten-title', 'Home')

@section('konten-header')
    <div class="section-header">
        <h1>Pegawai Home</h1>
    </div>
@endsection

@section('konten-main')
    
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
            <i class="fa fas fa-tasks"></i>
            </div>
            <div class="card-wrap">
            <div class="card-header">
                <h4>Total Tugas</h4>
            </div>
            <div class="card-body">
                {{ $allCount }}
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
            <i class="fa fas fa-cogs"></i>
            </div>
            <div class="card-wrap">
            <div class="card-header">
                <h4>Tugas Proses</h4>
            </div>
            <div class="card-body">
                {{ $totalProses }}
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
            <i class="fas fa fa-check"></i>
            </div>
            <div class="card-wrap">
            <div class="card-header">
                <h4>Tugas Selesai</h4>
            </div>
            <div class="card-body">
                {{ $doneCount }}
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                <div class="card-header">
                    <h4>SOP</h4>
                </div>
                <div class="card-body">
                    {{ $sop }}
                </div>
                </div>
            </div>
            </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Data Absensi</h4>
              <div class="card-header-action">
                  <a href="{{ route('absen.detail') }}" class="btn btn-primary">Lihat Lebih Lanjut <i class="fas fa fa-chevron-right"></i></a>
              </div>
            </div>
            <div class="card-body">
                <div class="fc-overflow">
                    <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                  </div>
            </div>
          </div>
        </div>
  
        <div class="col-lg-4 col-md-12 col-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Tugas On Progress</h4>
            </div>
            <div class="card-body">
              <ul class="list-unstyled list-unstyled-border">
                @foreach ($task as $data)   
                  <li class="media">
                    <div class="media-body">
                      <div class="float-right text-primary"><div class="badge badge-warning">{{ $data->status === 'pending' ? 'Pending' : 'Proses' }}</div></div>
                      <div class="media-title">{{ $data->task->tugas }}</div>
                      <span class="text-small text-muted">{{ $data->task->desc }}</span>
                    </div>
                  </li>
                @endforeach
              </ul>
              <div class="text-center pt-1 pb-1">
                <a href="{{ route('usertask.index') }}" class="btn btn-primary btn-lg btn-round">
                  View All
                </a>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h4>Download QR Code</h4>
            </div>
            <div class="card-body text-center">
                <div class="visible-print mb-3">
                  {!! QrCode::size(150)->generate($pegawai->nip); !!}
                </div>
              <div class="text-center pt-1 pb-1">
                <a href="{{ route('user.qrcode') }}" class="btn btn-success btn-lg btn-round">
                  <i class="fa fas fa-download"></i> Download
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>


@endsection
@push('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/api/absensi',
            eventDidMount: function(info) {
            // // Jika Anda ingin menambahkan logika tambahan saat event dimuat
            // if (info.event.extendedProps.status === 'Absen') {
                info.el.style.backgroundColor = 'blue'; // Mengubah warna latar belakang untuk event absen
                info.el.style.color = 'white'; // Mengubah warna teks
            // }
        }
  
  
        });
        calendar.render();
  
    });
  
  </script>
@endpush
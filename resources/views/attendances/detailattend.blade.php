@extends('layout.app')
{{-- @section('title-body', 'List Pegawai') --}}

@push('style')
  
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

@endpush

@section('konten-header')
<div class="section-header" >
  <h1>Rekap Data Absensi</h1>
</div>
@endsection

@section('konten-main')
    <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Absensi Minggu Ini</h4>
            </div>
            <div class="card-body">
              <div class="input-group">
                <input type="text" name="cariPegawai" placeholder="Cari Pegawai.." class="form-control">
                <div class="input-group-btn">
                  <button class="btn btn-primary">
                      <i class="fa fas fa-search"></i>
                  </button>
              </div>
              </div>
              <div class="table-responsive mt-2">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                     
                      <th class="text-center">
                        #
                      </th>
                      <th>NIP</th>
                      <th>Nama Pegawai</th>
                      <th>Jabatan</th>
                      <th>Bagian</th>
                      @foreach($data as $no=>$dataP)
                      <th>{{ $dataP }}</th>
                      @endforeach

                      @foreach (['H', 'T', 'I', 'S', 'A'] as $_st)
                        <th scope="col">
                          {{ $_st }}
                        </th>
                      @endforeach
                      
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($pegawai as $no=>$dataP)
                        {{-- @foreach($dataP->attendances as $dataA) --}}
                        <tr>
                          <td class="text-center">{{ $no+1 }}</td>
                          <td>{{ $dataP->nip }}</td>
                          <td>{{ $dataP->nama_pegawai }}</td>
                          <td>{{ $dataP->jabatan->jabatan }}</td>
                          <td>{{ $dataP->bagian->bagian }}</td>
                            @php
                              $presentCount = 0;
                              $lateCount = 0;
                              $excusedCount = 0;
                              $sickCount = 0;
                              $absentCount = 0;
                            @endphp
                            @foreach($data as $date)
                             
                              @php
                              // Mencari sttus absensi untuk tanggal tertentu
                              // $attendance = $dataP->attendances->firstWhere('formatted_date', $date);
                              // Mengubah format tanggal untuk perbandingan
                                $currentDate = \Carbon\Carbon::createFromFormat('d/m', $date)->format('Y-m-d');
                                $dayOfWeek = \Carbon\Carbon::createFromFormat('Y-m-d', $currentDate)->dayOfWeek; // 0 = Minggu, 6 = Sabtu
                              @endphp
                            <td>  
                              @if ($dayOfWeek == 0 || $dayOfWeek == 6)
                                  <!-- Jika hari Minggu (0) atau Sabtu (6), tampilkan output khusus -->
                                  -
                              @else
                                  <!-- Cek apakah pegawai hadir pada tanggal ini -->
                                  @php
                                      $attendance = $dataP->attendances->firstWhere('formatted_date', $date);
                                  @endphp
                                  @if ($attendance)
                                    @switch($attendance->status)
                                      @case('present')
                                          <div class="badge badge-success">H</div>
                                            @php
                                              $presentCount++;
                                            @endphp
                                          @break
                                      @case('late')
                                          <div class="badge badge-warning">T</div>
                                            @php
                                              $lateCount++;
                                            @endphp
                                          @break
                                      @case('excused')
                                          <div class="badge badge-info">I</div>
                                            @php
                                              $excusedCount++;
                                            @endphp
                                          @break
                                      @case('sick')
                                          <div class="badge badge-info">S</div>
                                            @php
                                              $sickCount++;
                                            @endphp
                                          @break
                                      @case('absent')
                                          <div class="badge badge-danger">-</div>
                                            @php
                                              $absentCount++;
                                            @endphp
                                          @break
                                      @default
                                          <div class="badge badge-secondary">N/A</div>
                                  @endswitch
                                  @else
                                    <div class="badge badge-danger">A</div>
                                      @php
                                          $absentCount++;
                                      @endphp
                                  @endif
                              @endif
                              
                            </td>
                            @endforeach

                            @foreach ([$presentCount,$lateCount,$excusedCount,$sickCount,$absentCount] as $statusCount)
                              <td style=" text-align: center;">
                                {{ $statusCount }}
                              </td>
                            @endforeach
                        </tr>
                        {{-- @endforeach --}}
                      @endforeach
                  </tbody>
                </table>
              </div>
                <!-- Menampilkan link pagination -->
                <div class="d-flex justify-content-end mt-2">
                  <!-- Ini akan menampilkan link pagination -->
                </div>
            </div>
          </div>
        </div>
      </div>
                
            </div>
              
              
  


@endsection

@push('scripts')

<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
{{-- <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script> --}}

{{-- <script>

  $(document).ready( function () {
    $('#table-1').DataTable();
  } );
</script> --}}

@endpush


                  
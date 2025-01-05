@extends('layout.app')
{{-- @section('title-body', 'List Pegawai') --}}

@push('style')
  
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

@endpush

@section('konten-header')
<div class="section-header" >
  <h1>List Presensi Masuk</h1>
</div>
@endsection

@section('konten-main')
    <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Absensi Hari Ini</h4>
            </div>
            <div class="card-body">
              
                
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
                            @foreach($data as $date)
                              {{-- <td>
                                @if ($dataA->date == $date)
                                  {{ $dataA->status }}
                                @else
                                    -
                                @endif
                              </td>  --}}
                              @php
                              
                              // Mencari sttus absensi untuk tanggal tertentu
                              $attendance = $dataP->attendances->firstWhere('formatted_date', $date);
                              @endphp
                              <td>{{ $attendance->status ?? '-' }}</td>
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


                  
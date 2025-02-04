@extends('layout.app')

@section('konten-title', 'Gaji Pegawai')


@section('konten-header')
    <div class="section-header">
        <h1>Gaji Pegawai</h1>
    </div>
@endsection

@section('konten-main')

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Tabel Data Pegawai</h4>
                    <div class="card-header-action">
                      <a class="btn btn-success" href="{{ route('gaji.create') }}"><i class="fa fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <div class="card-body">
                  <form action="#" method="get">
                  <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="nip" class="col-form-label">Bulan Ke :</label>
                        <select class="custom-select form-control" name="monthInputs" id="month">
                              @foreach($months as $month)
                                    <option value="{{ $month['value'] }}" @if($month['is_current']) selected @endif>{{ $month['label'] }}</option>
                              @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2" >
                      <label for="btnfilter" class="col-form-label">&nbsp;</label>
                      <button class="btn btn-info form-control" name="btnfilter"><i class="fa fas fa-filter"></i> Filter</button>
                  </div>
                  </div>
                </form>
                
                <div class="d-flex justify-content-end">
                  Bulan : {{ $monthInputStatus }}
                </div>
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th class="text-center">NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Gaji Pokok</th>
                            <th>Total Gaji</th>
                            <th>Slip Gaji</th>
                            <th>Aksi</th>
                            
                          </tr>
                        </thead>
                        <tbody>
      
                          @foreach($pegawai as $no=>$data)
                          <tr>
                              <td class="text-center">{{ $no+1 }}</td>
                              <td>{{ $data->nip }}</td>
                              <td>{{ $data->nama_pegawai }}</td>
                              <td>Rp. {{ $data->gaji_pokok }}</td>
                              <td>Rp. {{ $data->gaji->total_gaji ?? '-' }}</td>
                              <td>Gaji</td>
                              <td class="d-flex align-items-start">
                                  <a href="{{ route('pegawai.edit', $data->id) }}" class="btn btn-primary btn-sm me-2 mr-2 ">Detail</a>
                                  
                              </td>
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

@push('scripts')
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
@endpush
@extends('layout.app')

@push('styles')
{{-- <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"> --}}
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet"> --}}
@endpush

@section('konten-header')
<div class="section-header">
  <h1>Tambah Pegawai</h1>
</div>
@endsection
@section('konten-main')

<div>
    <a href="{{ back()->getTargetUrl() }}" class="btn btn-danger">Back</a>
</div>

<div class="row justify-content-center mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Form Data Pegawai</h4>
            </div>
            <div class="card-body text-start">
                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <form action="{{ route('pegawai.post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nomor Induk Pegawai</label>
                            <input type="text" name="nip" class="form-control mb-2">
                            <label for="">Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" class="form-control mb-2">
                            <label for="">Alamat</label>
                            <input type="text" name="alamat" class="form-control mb-2">
                            <label for="">Gender</label>
                            <div class="input-group mb-3">
                                <select class="custom-select form-control" name="gender">
                                    <option selected disabled>Pilih Jenis Kelamin..</option>
                                    <option value="1">Laki - Laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                              </div>
                            <label for="">Foto</label>
                            <input type="file" name="foto" class="form-control mb-2">
                            {{-- <input type="text" name="gender" class="form-control mb-2"> --}}
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Lahir</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="date" class="form-control" name="tgl_lahir">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            {{-- <input type="text" name="tgl_lahir" class="form-control mb-2" placeholder="YYYY/MM/DD"> --}}
                            <label for="">Jabatan</label>
                            <div class="input-group mb-3">
                            <select class="form-control" name="jabatan" required>
                                <option selected disabled>Pilih Jabatan..</option>
                                @foreach($jabatan as $data_jabatan)
                                    <option value="{{ $data_jabatan->id }}">{{ $data_jabatan->jabatan }}</option>
                                @endforeach
                            </select>
                            </div>

                            <label for="">Bagian</label>
                            <div class="input-group mb-3">
                            <select class="form-control" name="bagian" required>
                                <option selected disabled>Pilih Bagian..</option>
                                @foreach($bagian as $data_bagian)
                                    <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                                @endforeach
                            </select>
                            </div>

                            <label for="">Shift</label>
                            <div>
                            <select class="form-control" name="shift" required>
                                <option selected disabled>Pilih Shift..</option>
                                @foreach($shift as $data_shift)
                                    <option value="{{ $data_shift->id }}">{{ $data_shift->shift }}</option>
                                @endforeach
                            </select>
                            </div>
                            
                           
                        </div>
                    </div>
                    
                    
                    <div class="d-flex justify-content-end">

                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')

{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script>

$('.datepicker').datepicker({
    format: 'mm-dd-yyyy',
    startDate: '-3d' 
}); 

</script>  --}}

{{-- <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script> --}}

{{-- <script src="{{ asset('library/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script> --}}

{{-- <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script> --}}

@endpush


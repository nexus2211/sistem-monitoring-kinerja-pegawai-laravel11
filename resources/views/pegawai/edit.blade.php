@extends('layout.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endpush

@section('title-body', 'Edit Pegawai')
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
                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div>
                        <label for="foto">Foto</label>
                    </div>
                        @isset($pegawai->foto)
                            <img src="{{ asset(getenv('CUSTOM_NAME_LOCATION').'/'.$pegawai->foto) }}" alt="" class="img-thumbnail w-25 h-25">
                        @endisset
                    <input type="file" name="foto" class="form-control mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nomor Induk Pegawai</label>
                            <input type="text" name="nip" class="form-control mb-2" value="{{ $pegawai->nip }}">
                            <label for="">Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" class="form-control mb-2" value="{{ $pegawai->nama_pegawai }}">
                            <label for="">Alamat</label>
                            <input type="text" name="alamat" class="form-control mb-2" value="{{ $pegawai->alamat }}">
                            <label for="">Gender</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="gender">
                                    <option value="1" {{ $pegawai->gender == 'Laki - Laki' ? 'selected' : '' }}>Laki - Laki</option>
                                    <option value="2" {{ $pegawai->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                              </div>
                            
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Lahir</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input readonly type="text" class="form-control" name="tgl_lahir" value="{{ $pegawai->tgl_lahir }}">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label for="">Jabatan</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="jabatan" required>
                                    <option selected disabled>Pilih Jabatan..</option>
                                    @foreach($jabatan as $data_jabatan)
                                        <option value="{{ $data_jabatan->id }}"  {{ $data_jabatan->id == $pegawai->jabatan_id ? 'selected' : '' }}>{{ $data_jabatan->jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="">Bagian</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="bagian" required>
                                    <option selected disabled>Pilih Bagian..</option>
                                    @foreach($bagian as $data_bagian)
                                        <option value="{{ $data_bagian->id }}" {{ $data_bagian->id == $pegawai->bagian_id ? 'selected' : '' }}>{{ $data_bagian->bagian }}</option>
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
                    
                    
                    <div class="d-flex justify-content-end d-flex">

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script>

$('.datepicker').datepicker({
    format: 'mm-dd-yyyy',
    startDate: '-3d' 
}); 

</script> 
@endpush
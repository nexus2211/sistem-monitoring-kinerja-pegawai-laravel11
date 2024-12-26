@extends('layout.app')

@push('styles')

@endpush

@section('konten-header')
<div class="section-header">
  <h1>Edit Jabatan</h1>
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
                <h4>Form Data Jabatan</h4>
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
                <form action="{{ route('jabatan.update', $jabatan->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nama Jabatan</label>
                            <input type="text" name="jabatan" class="form-control mb-2" value="{{ $jabatan->jabatan }}">
                            <label for="">Deskripsi</label>
                            <input type="text" name="deskripsi" class="form-control mb-2" value="{{ $jabatan->deskripsi }}">
                            
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


</script> 
@endpush
@extends('layout.app')
@push('style')
    
    
@endpush

@section('konten-header')
    <div class="section-header">
        <h1>SOP Pegawai</h1>
    </div>
@endsection

@section('konten-main')
    <div>
        <div class="card card-primary">
            <div class="card-header"><h4>SOP Form</h4></div>
            <div class="card-body text-start">
                <div class="container">
                    <form action="#" method="post">
                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="email">Title SOP</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="titleSop" class="form-control"> 
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="bagianSop">Untuk Bagian :</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="bagianSop" class="form-control"> 
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="contentSop">Content SOP</label>
                            <div class="col-sm-12 col-md-7">
                                {{-- <textarea name="contentSop" id="summernote" cols="65" rows="10"></textarea>  --}}
                                <textarea class="summernote"></textarea>
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="email"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Submit</button>
                            </div>        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
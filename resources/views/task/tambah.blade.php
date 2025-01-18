@extends('layout.app')

@push('style')
    
@endpush

@section('konten-header')
    <div class="section-header">
        <h1>Tambah Tugas</h1>
    </div>
@endsection

@section('konten-main')
    

<div class="row justify-content-center mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Form Tambah Tugas</h4>
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
                <form action="#" method="post" enctype="multipart/form-data">
                    
                    @csrf
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="tugasInput">Nama Tugas</label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" name="tugasInput" class="form-control"> 
                                </div>        
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="descInput">Keterangan Tugas</label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" name="descInput" class="form-control"> 
                                </div>        
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="bagianInput">Bagian :</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control select2" name="bagianInput">
                                        <option selected disabled>Pilih Bagian..</option>
                                        {{-- @foreach($bagian as $data_bagian)
                                            <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>        
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="descInput">Waktu Mulai/Deadline</label>
                                <div class="col-sm-12 col-md-3 mb-4 mb-md-0"> 
                                    <input type="text" name="mulaiInput" class="form-control datetimepicker"> 
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" name="deadlineInput" class="form-control datetimepicker"> 
                                </div>          
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="sopInput">SOP Tugas :</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control select2" name="sopInput">
                                        <option selected disabled>Pilih SOP..</option>
                                        {{-- @foreach($bagian as $data_bagian)
                                            <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>        
                            </div>
   
                            </div>
                        </div>
                    </div>                  
                    <div class="d-flex justify-content-end d-flex">

                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Table Tugas</h4>
                    <div class="card-header-action">
                        <select class="form-control" name="bagianInput2">
                            <option selected disabled>Pilih Bagian..</option>
                            {{-- @foreach($bagian as $data_bagian)
                                <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="card-body ">
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <div class="custom-checkbox custom-control">
                                      <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                      <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                  </th>
                                  <th>Task Name</th>
                                  <th>Progress</th>
                                  <th>Members</th>
                                  <th>Due Date</th>
                                  <th>Status</th>
                                  <th>Action</th>
                            </tr>
                            <tr>
                                <td class="p-0 text-center">
                                    <div class="custom-checkbox custom-control">
                                      <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                      <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                    </div>
                                  </td>
                                  <td>Create a mobile app</td>
                                  <td class="align-middle">
                                    <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                                      <div class="progress-bar bg-success" data-width="100"></div>
                                    </div>
                                  </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>



@endsection

@push('scripts')

{{-- <script src="{{ asset('/assets/js/page/forms-advanced-forms.js') }}"></script> --}}
{{-- <script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datepicker();
    });
 </script> --}}

 <script src="{{ asset('/assets/js/page/components-table.js') }}"></script>
    
    
@endpush
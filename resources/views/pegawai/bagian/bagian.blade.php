@extends('layout.app')
@section('title-body', 'List bagian')

@push('style')
  
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

@endpush

@section('konten-main')

    <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
                <h4>Tabel Data bagian</h4>
          </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-2">
                  <thead>
                    <tr>
                     
                      <th>Bagian</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                      
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($bagian as $no=>$data)
                    <tr>
                        
                        <td>{{ $data->bagian }}</td>
                        <td>{{ $data->deskripsi }}</td>
                        <td class="d-flex align-items-center" style="width: 50px;">
                            <a href="{{ route('bagian.edit', $data->id) }}" class="btn btn-warning btn-sm me-2 mr-2 ">Edit</a>    
                            <form action="{{ route('bagian.delete', $data->id) }}" method="post"  onsubmit="return confirm('Yakin ingin menghapus data?')">
                              @csrf
                              @method('delete')
                              <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Data Bagian</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bagian.post') }}" method="post">
                        @csrf
                        <label for="">Nama bagian</label>
                        <input type="text" name="bagian" class="form-control mb-2">
                        <label for="">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control mb-2">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary mt-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
  

@endsection

@push('scripts')

<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>



<script>

  $(document).ready( function () {
    $('#table-2').DataTable();
  } );
</script>



@endpush
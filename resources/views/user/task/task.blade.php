@extends('layout.app')
@section('konten-title', 'Data Tugas')

@section('konten-header')
<div class="section-header">
    <h1>List Tugas</h1>
</div>
@endsection

@section('konten-main')

    <div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>List Tugas</h4>
                
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Tugas</th>
                                    <th>Bagian</th>
                                    <th>Status</th>
                                    <th>Waktu Mulai Tugas</th>
                                    <th>Deadline</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 0;
                                @endphp
                                {{-- @foreach ($pegawai as $data)  --}}
                                    @foreach ($pegawai->tasks as $taskData)   
                                        <tr>
                                            <td class="text-center">{{ ++$no }}</td>
                                            <td>{{ $taskData->tugas }}</td>
                                            <td>{{ $taskData->bagian->bagian }}</td>
                                            <td><div class="badge {{ $taskData->pivot->status === 'done' ? 'badge-success' : 'badge-warning' }}">{{ $taskData->pivot->status === 'pending' ? 'Pending' : ($taskData->pivot->status === 'process' ? 'Proses' : ($taskData->pivot->status === 'done' ? 'Selesai' : $taskData->pivot->status))}}</div></td>
                                            <td><div class="badge badge-info">{{ $taskData->waktu_mulai }}</div></td>
                                            <td><div class="badge badge-info">{{ $taskData->waktu_deadline }}</div></td>
                                            <td><a href="{{  route('usertask.detail', $taskData->pivot->id)  }}" class="btn btn-sm btn-primary">Detail</a></td>
                                        </tr>                                  
                                    @endforeach                  
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2">
                    {{-- {{ $pegawai->links() }} --}}
                </div>

            </div>
        </div>
    </div>
    
@endsection
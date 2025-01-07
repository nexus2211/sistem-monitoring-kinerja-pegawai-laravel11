@extends('layout.app')


@section('konten-main')

    <h1>Ini dashboard</h1>

    {{-- $attendance = $dataP->attendances->firstWhere('formatted_date', $date); --}}

    {{-- @if($attendance)
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
  @endif --}}

@endsection
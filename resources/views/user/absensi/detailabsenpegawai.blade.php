@extends('layout.app')
@push('style')
    <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('/library/fullcalendar/dist/fullcalendar.min.css') }}">

  
@endpush

@section('konten-header')
    
@endsection

@section('konten-main')
    
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('/library/fullcalendar/dist/fullcalendar.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('/assets/js/page/modules-calendar.js') }}"></script>
    
@endpush
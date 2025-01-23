<meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Aplikasi Pegawai &mdash; @yield('konten-title')</title>

  <!-- General CSS Files -->

 

  <link rel="stylesheet" href="{{ asset('/library/bootstrap/dist/css/bootstrap.min.css') }}">
  
  {{-- <link rel="stylesheet" href="{{ asset('/library/font-awesome/css/font-awesome.min.css') }}"> --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/skins/reverse.css') }}">

  {{-- Jqeury --}}
  
  <script src="{{ asset('/library/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('/library/moment/min/moment.min.js') }}"></script>
  
  
  {{-- select 2 --}}
  <link rel="stylesheet" href="{{ asset('/library/select2/dist/css/select2.min.css') }}">
  <script src="{{ asset('/library/select2/dist/js/select2.full.min.js') }}"></script>

  {{-- time picker --}}
  <link rel="stylesheet" href="{{ asset('/library/bootstrap-daterangepicker/daterangepicker.css') }}">
  <script src="{{ asset('/library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  

  <link rel="stylesheet" href="{{ asset('/library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
  <script src="{{ asset('/library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
 

  <!-- include summernote css/js -->
  <link rel="stylesheet" href="{{ asset('/library/summernote/dist/summernote-bs4.css') }}">
  <script src="{{ asset('/library/summernote/dist/summernote-bs4.js') }}"></script>

  {{-- Data Table --}}
  <link rel="stylesheet" href="{{ asset('/library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

  <script src="{{ asset('/library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('/library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src=" {{ asset('/library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

  @stack('styles')
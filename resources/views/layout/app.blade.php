<!DOCTYPE html>
<html lang="en">
<head>
  


  @include('layout/_partials/head')
  

</head>

<body>
  
  <div id="app">
    <div class="main-wrapper">

      @guest
          @yield('auth')
      @endguest
      
      @auth
          
     
      {{-- Top Bar --}}
      
      @include('layout/_partials/topbar')
      
      {{-- End of Top Bar --}}
      


      {{-- Side bar --}}

      @include('layout/_partials/sidebar')

      {{-- End of Side Bar --}}



      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          {{-- <div class="section-header">
            <h1>@yield('title-body')</h1>
          </div> --}}
          @yield('konten-header')

          <div class="section-body">
            
            @yield('konten-main')
            
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2024 <div class="bullet"></div>Web By Gasom & Stisla Template Design By <a href="https://nauv.al/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>

      @endauth
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

  <!-- JS Libraies -->
  {{-- <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script> --}}
  

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>


  <!-- Page Specific JS File -->

  
 

  @stack('scripts')
</body>
</html>

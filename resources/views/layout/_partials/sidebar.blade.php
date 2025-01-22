<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">Monitoring Pegawai</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">MP</a>
      </div>
      <ul class="sidebar-menu">
          

          @if (Auth::check())
            @if (Auth::user()->type === 'admin' || Auth::user()->type === 'manager')

              <li class="menu-header">Dashboard</li>
              <li class="nav-item dropdown {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
              </li>

              <li class="menu-header">Master Data</li>
              <li class="nav-item dropdown {{ Request::routeIs('pegawai','jabatan','bagian','shift') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-user"></i> <span>Data Pegawai</span></a>
                <ul class="dropdown-menu">
                  <li class="{{ request()->routeIs('pegawai') ? 'active' : '' }}"><a class="nav-link" href="{{ route('pegawai') }}">List Pegawai</a></li>
                  <li class="{{ request()->routeIs('jabatan') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jabatan') }}">List Jabatan</a></li>
                  <li class="{{ request()->routeIs('bagian') ? 'active' : '' }}"><a class="nav-link" href="{{ route('bagian') }}">List Bagian</a></li>
                  <li class="{{ request()->routeIs('shift') ? 'active' : '' }}"><a class="nav-link" href="{{ route('shift') }}">List Shift</a></li>
                </ul>
              </li>
    
              <li class="{{ Request::routeIs('rekapdata','detailAttendances','listAttendances','detailAttendancesMonth') ? 'active' : '' }}"><a class="nav-link" href="{{ route('rekapdata') }}"><i class="fa far fa-table"></i> <span>Rekap Data</span></a></li>
    
              <li class="menu-header">Manajemen</li>
    
              <li class="{{ Request::routeIs('sop.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sop.index') }}"><i class="fa far fa-file"></i> <span>SOP Pegawai</span></a></li>
    
              <li class="{{ Request::routeIs('task.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('task.index') }}"><i class="fa far fa-tasks"></i> <span>Tugas Pegawai</span></a></li>
    
              <li class="menu-header">Attendances</li>
    
              <li class="nav-item dropdown {{ Request::routeIs('attendances.in','attendances.out') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far far fa-clipboard"></i> <span>Absensi</span></a>
                <ul class="dropdown-menu">
                  <li class="{{ request()->routeIs('attendances.in') ? 'active' : '' }}"><a class="nav-link" href="{{ route('attendances.in') }}">Absen Masuk</a></li>
                  <li class="{{ request()->routeIs('attendances.out') ? 'active' : '' }}"><a class="nav-link" href="{{ route('attendances.out') }}">Absen Keluar</a></li>
                </ul>
              </li>
              
              <li class="{{ Request::routeIs('barcode.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('barcode.index') }}"><i class="fa far fa-qrcode"></i> <span>QR Code</span></a></li>
                  
              <li class="menu-header">Manage User</li>
    
              <li class="{{ Request::routeIs('manageuser.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('manageuser.index') }}"><i class="fa far fa-user-circle"></i> <span>Manage User</span></a></li>      


              @elseif(Auth::user()->type === 'user')
              <li class="menu-header">Home</li>
                <li class="nav-item {{ request()->routeIs('home.pegawai') ? 'active' : '' }}">
                  <a href="{{ route('home.pegawai') }}" class="nav-link"><i class="fas fa-fire"></i><span>Home</span></a>
                </li>

              <li class="menu-header">Home</li>

                <li class="nav-item {{ request()->routeIs('absen.masuk') ? 'active' : '' }} ">
                  <a href="{{ route('absen.masuk') }}" class="nav-link"><i class="far far fa-clipboard"></i><span>Absen Masuk</span></a>
                </li>

                <li class="nav-item {{ request()->routeIs('absen.keluar') ? 'active' : '' }} ">
                  <a href="{{ route('absen.keluar') }}" class="nav-link"><i class="fa fas fa-check"></i><span>Absen Keluar</span></a>
                </li>
            @endif
          @endif
          
    
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
          <a href="https://github.com/capcay464/sistem-monitoring-kinerja-pegawai-laravel11" class="btn btn-primary btn-lg btn-block btn-icon-split" target="__blank">
            <i class="fas fa-rocket"></i> Documentation
          </a>
        </div>
    </aside>
  </div>
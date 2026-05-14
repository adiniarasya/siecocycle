<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    
    <!-- ===== LOGO ===== -->
    <div class="sidebar-brand">
      <a href="#">Siecocycle</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="#">SC</a>
    </div>

    <!-- ===== MENU ===== -->
    <ul class="sidebar-menu">

      <!-- ===== MENU TANPA DROPDOWN ===== -->
      <li class="menu-header">Main Menu</li>
      @if(Auth::user()->role == "warga")
      <li>
        <a class="nav-link" href="/warga/dashboard">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li>
      @elseif(Auth::user()->role == "mitra")
        <li>
        <a class="nav-link" href="/dashboard/mitra">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-clipboard"></i>
          <span>Riwayat Setoran</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="#">Disetujui</a></li>
          <li><a class="nav-link" href="#">Ditolak</a></li>
        </ul>
      </li>
      @else
      <li>
        <a class="nav-link" href="/dashboard/admin">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li>
      


      <!-- ===== MENU DENGAN DROPDOWN ===== -->
      <li class="menu-header">Management</li>
       <li>
        <a class="nav-link" href="/admin/setoran">
          <i class="fas fa-recycle"></i>
          <span>Data Setoran</span>
        </a>
      </li>
      <li>
        <a class="nav-link" href="/admin/mitra">
          <i class="fas fa-university"></i>
          <span>Data Mitra</span>
        </a>
      </li>
      <!-- Dropdown 1 -->
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-users"></i>
          <span>Users</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="#">Data User</a></li>
          <li><a class="nav-link" href="#">Tambah User</a></li>
        </ul>
      </li>

      <!-- Dropdown 2 -->
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-gift"></i>
          <span>Reward</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="#">Daftar Reward</a></li>
          <li><a class="nav-link" href="#">Penukaran</a></li>
        </ul>
      </li>

      <li class="menu-header">Reports</li>
      <li>
        <a class="nav-link" href="/reports">
          <i class="fas fa-file"></i>
          <span>Laporan</span>
        </a>
      </li>
      @endif
      

    </ul>

  </aside>
</div>
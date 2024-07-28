<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= htmlspecialchars($response_data['username'])?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="index.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">
            <i ></i>
            <p>Profile</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="userdata.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'userdata.php') ? 'active' : '' ?>">
            <i class aria-hidden="true"></i>
            <p>User Data</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="jdh.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'jdh.php') ? 'active' : '' ?>">
            <i  aria-hidden="true"></i>
            <p>Jaringan Dokumentasi</p>
          </a>
        </li>
          <li class="nav-item">
            <a href="forum.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'forum.php') ? 'active' : '' ?>">
              <i  aria-hidden="true"></i>
              <p>Forum</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="layananpengaduan.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'layananpengaduan.php') ? 'active' : '' ?>">
              <i  aria-hidden="true"></i>
              <p>Layanan Pengaduan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="streaming.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'streaming.php') ? 'active' : '' ?>">
              <i aria-hidden="true"></i>
              <p>Streaming</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="schedules.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'schedules.php') ? 'active' : '' ?>">
              <i aria-hidden="true"></i>
              <p>Schedules</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="posbantuanhukum.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'posbantuanhukum.php') ? 'active' : '' ?>">
              <i aria-hidden="true"></i>
              <p>Pos Bantuan Hukum</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="persalinan.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'persalinan.php') ? 'active' : '' ?>">
              <i aria-hidden="true"></i>
              <p>Permohonan Persalinan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="gugatansederhana.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'gugatansederhana.php') ? 'active' : '' ?>">
              <i aria-hidden="true"></i>
              <p>Gugatan Sederhana</p>
            </a>
          </li>

      </ul>
    </nav>
    </div>
    <!-- /.sidebar -->
  </aside>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ !empty($header_title) ? $header_title : '' }} - {{__('messages.school')}}</title>
  @php
    $getHeaderSetting = App\Models\SettingModel::getSingle();
  @endphp
  <link href="{{ $getHeaderSetting->getFevicon() }}" rel="icon" type="image/jpg" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!-- Bootstrap Icons -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ url('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.min.css') }}">

  @yield('style')
    <!-- Dark Mode Styles -->
    <style>
  /* Default (Light) mode styles */
body {
    background-color: #ffffff !important;
    color: #333333 !important;
    transition: all 0.3s ease;
}

/* Navbar Light Mode Styles */
.main-header {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #dee2e6 !important;
}

.navbar-light .navbar-nav .nav-link {
    color: #333333 !important;
    font-weight: 500 !important;
}

.navbar-light .navbar-nav .nav-link:hover {
    color: #007bff !important;
    background-color: rgba(0, 123, 255, 0.1) !important;
}

.navbar-light .navbar-nav .nav-link.active {
    color: #007bff !important;
    background-color: rgba(0, 123, 255, 0.1) !important;
}

/* Sidebar Light Mode */
.main-sidebar {
    background-color: #343a40 !important;
}

.main-sidebar .nav-link {
    color: #ffffff !important;
}

.main-sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}

/* Dark mode styles */
body.dark-mode {
    background-color: #1a1a1a !important;
    color: #e4e6eb !important;
}

body.dark-mode .main-header {
    background-color: #242526 !important;
    border-bottom: 1px solid #393a3b !important;
}

body.dark-mode .navbar-nav .nav-link {
    color: #e4e6eb !important;
}

body.dark-mode .navbar-nav .nav-link:hover {
    background-color: #3a3b3c !important;
    color: #ffffff !important;
}

body.dark-mode .main-sidebar {
    background-color: #242526 !important;
}

body.dark-mode .nav-link {
    color: #e4e6eb !important;
}

body.dark-mode .nav-link:hover {
    background-color: #3a3b3c !important;
    color: #ffffff !important;
}

/* Rest of your dark mode styles... */
body.dark-mode .card,
body.dark-mode .info-box {
    background-color: #242526 !important;
    color: #e4e6eb !important;
    border: 1px solid #393a3b !important;
}

body.dark-mode .table {
    color: #e4e6eb !important;
    background-color: #242526 !important;
}

/* Smooth transitions */
.main-header,
.main-sidebar,
.nav-link,
.navbar {
    transition: all 0.3s ease !important;
}
    </style>
 </head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  @include('layouts.header')
  @yield('content')
  @include('layouts.footer')
  
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ url('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ url('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ url('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ url('plugins/moment/moment.min.js') }}"></script>
<script src="{{ url('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->

<script src="{{ url('dist/js/pages/dashboard.js') }}"></script>

@yield('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
      const darkModeToggle = document.getElementById('darkModeToggle');
      const darkModeIcon = document.getElementById('darkModeIcon');
      const darkModeText = document.getElementById('darkModeText');
      
      // Check if user preference exists
      const isDarkMode = localStorage.getItem('darkMode') === 'true';
      
      // Set initial state
      setDarkMode(isDarkMode);
          });

</script>
</body>
</html>

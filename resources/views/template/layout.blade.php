<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Siecocycle</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/css/components.css')}}">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
<!-- ===== WRAPPER APP START ===== -->
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <!-- ===== NAVBAR BACKGROUND ===== -->
      <div class="navbar-bg"></div>
      <!-- ===== NAVBAR START ===== -->
      @include('template/navbar')
      <!-- ===== NAVBAR END ===== -->

      <!-- ===== SIDEBAR START ===== -->
      @include('template/sidebar')
      <!-- ===== SIDEBAR END ===== -->

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield('title')</h1>
           
          </div>

          <div class="section-body">
            @yield('content')
          </div>
        </section>
      </div>
        <!-- ===== MAIN CONTENT END ===== -->

        <!-- ===== FOOTER START ===== -->
        @include('template/footer')      
      <!-- ===== FOOTER END ===== -->
    </div>
  </div>
  <!-- ===== WRAPPER APP END ===== -->

  <!-- General JS Scripts -->
  <script src="{{ asset('Stisla/dist/assets/modules/jquery.min.js')}}"></script>
  <script src="{{ asset('Stisla/dist/assets/modules/popper.js')}}"></script>
  <script src="{{ asset('Stisla/dist/assets/modules/tooltip.js')}}"></script>
  <script src="{{ asset('Stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('Stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('Stisla/dist/assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('Stisla/dist/assets/js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="{{ asset('Stisla/dist/assets/js/scripts.js')}}"></script>
  <script src="{{ asset('Stisla/dist/assets/js/custom.js')}}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
              const alerts = document.querySelectorAll('.alert');
              
              alerts.forEach(function(alert) {
                 
                  setTimeout(function() {
                      alert.style.transition = 'opacity 0.5s ease';
                      alert.style.opacity = '0';
                      setTimeout(function() {
                          alert.remove();
                      }, 500); 
                  }, 3000);
              });
          });
  </script>
  @stack('scripts')
</body>
</html>
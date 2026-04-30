<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register &mdash; SiEcoCycle</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/modules/fontawesome/css/all.min.css')}}">
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/modules/jquery-selectric/selectric.css')}}">
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('Stisla/dist/assets/css/components.css')}}">
</head>

<body>
<div id="app">
<section class="section">
<div class="container mt-5">
<div class="row">
<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2">

  <div class="login-brand">
    <img src="{{ asset('Stisla/dist/assets/img/logoeco.jpeg')}}" width="100" class="shadow-light rounded-circle">
  </div>

  <div class="card card-primary">
    <div class="card-header"><h4>Register</h4></div>

    <div class="card-body">

      {{-- ALERT --}}
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
          <label>Name</label>
          <input type="text" class="form-control" name="name" required>
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>

        <div class="row">
          <div class="form-group col-6">
            <label>Password</label>
            <input type="password" class="form-control pwstrength" name="password">
            <div id="pwindicator" class="pwindicator">
              <div class="bar"></div>
              <div class="label"></div>
            </div>
          </div>

          <div class="form-group col-6">
            <label>Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation">
          </div>
        </div>

        <div class="form-group">
          <label>Role</label>
          <select class="form-control" name="role" required>
            <option value="">Pilih Role</option>
            <option value="warga">Warga</option>
            <option value="mitra">Mitra</option>
          </select>
        </div>

        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="agree">
            <label class="custom-control-label" for="agree">
              I agree with the terms and conditions
            </label>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block">
            Register
          </button>
        </div>

      </form>
    </div>
  </div>

</div>
</div>
</div>
</section>
</div>

<!-- JS -->
<script src="{{ asset('Stisla/dist/assets/modules/jquery.min.js')}}"></script>
<script src="{{ asset('Stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('Stisla/dist/assets/js/stisla.js')}}"></script>
<script src="{{ asset('Stisla/dist/assets/js/scripts.js')}}"></script>

</body>
</html>
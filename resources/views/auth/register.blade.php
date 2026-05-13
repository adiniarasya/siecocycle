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
              <img src="{{ asset('Stisla/dist/assets/img/logoeco.jpeg')}}" width="100"
                class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>

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
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label>Password</label>
                      <input type="password" class="form-control pwstrength" name="password" required>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                      @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-6">
                      <label>Confirm Password</label>
                      <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Daftar sebagai</label>
                    <select class="form-control" name="role" id="role" required>
                      <option value="">Pilih Role</option>
                      <option value="warga" {{ old('role')=='warga' ? 'selected' : '' }}>Warga</option>
                      <option value="mitra" {{ old('role')=='mitra' ? 'selected' : '' }}>Mitra (Bank Sampah)</option>
                    </select>
                    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <!-- Field khusus Warga (RW Name) -->
                  <div id="warga_fields" style="display: none;">
                    <div class="form-group">
                      <label>Nama RW (contoh: RW 05)</label>
                      <input type="text" class="form-control" name="rw_name" value="{{ old('rw_name') }}">
                      @error('rw_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                  </div>

                  <!-- Field khusus Mitra (Alamat & Telepon) -->
                  <div id="mitra_fields" style="display: none;">
                    <div class="form-group">
                      <label>Alamat Bank</label>
                      <textarea class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                      @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                      <label>Nomor Telepon</label>
                      <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                      @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
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
            <div class="mt-5 text-muted text-center">
              Already have account? <a href="{{ route('login') }}">Login</a>
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const roleSelect = document.getElementById('role');
      const wargaFields = document.getElementById('warga_fields');
      const mitraFields = document.getElementById('mitra_fields');
      const rwNameInput = document.querySelector('input[name="rw_name"]');
      const addressInput = document.querySelector('textarea[name="address"]');
      const phoneInput = document.querySelector('input[name="phone"]');

      function toggleFields() {
        const selectedRole = roleSelect.value;
        if (selectedRole === 'warga') {
          wargaFields.style.display = 'block';
          mitraFields.style.display = 'none';
          if (rwNameInput) rwNameInput.setAttribute('required', 'required');
          if (addressInput) addressInput.removeAttribute('required');
          if (phoneInput) phoneInput.removeAttribute('required');
        } else if (selectedRole === 'mitra') {
          wargaFields.style.display = 'none';
          mitraFields.style.display = 'block';
          if (rwNameInput) rwNameInput.removeAttribute('required');
          if (addressInput) addressInput.setAttribute('required', 'required');
          if (phoneInput) phoneInput.setAttribute('required', 'required');
        } else {
          wargaFields.style.display = 'none';
          mitraFields.style.display = 'none';
          if (rwNameInput) rwNameInput.removeAttribute('required');
          if (addressInput) addressInput.removeAttribute('required');
          if (phoneInput) phoneInput.removeAttribute('required');
        }
      }

      roleSelect.addEventListener('change', toggleFields);
      toggleFields();
    });
  </script>
</body>

</html>
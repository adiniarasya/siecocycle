@extends('template.layout')

@section('title', 'Atur Lokasi Bank')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Lokasi Bank: {{ $bank->name }}</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.banks.location.update', $bank) }}" method="POST" id="locationForm">
                    @csrf
                    @method('PUT')
                    <div id="map" style="height: 450px; width: 100%; margin-bottom: 15px;"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control"
                                    value="{{ old('latitude', $bank->latitude) }}" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control"
                                    value="{{ old('longitude', $bank->longitude) }}" readonly required>
                            </div>
                        </div>
                    </div>

                
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Simpan Lokasi</button>
                        <a href="{{ route('admin.mitra') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=geometry"
    async defer></script>
<script>
    let map, marker, geocoder;

    function initMap() {
        const lat = parseFloat(document.getElementById('latitude').value) || -6.3483175211230565;
        const lng = parseFloat(document.getElementById('longitude').value) || 106.78427832614517;
        const center = { lat: lat, lng: lng };

        map = new google.maps.Map(document.getElementById('map'), {
            center: center,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        marker = new google.maps.Marker({
            position: center,
            map: map,
            draggable: true,
            title: 'Seret untuk menentukan lokasi bank'
        });

        geocoder = new google.maps.Geocoder();

        // Update koordinat dan alamat saat marker dipindah
        marker.addListener('dragend', function() {
            const pos = marker.getPosition();
            document.getElementById('latitude').value = pos.lat();
            document.getElementById('longitude').value = pos.lng();
            updateAddress(pos.lat(), pos.lng());
        });

        // Klik pada peta juga memindahkan marker
        map.addListener('click', function(e) {
            marker.setPosition(e.latLng);
            document.getElementById('latitude').value = e.latLng.lat();
            document.getElementById('longitude').value = e.latLng.lng();
            updateAddress(e.latLng.lat(), e.latLng.lng());
        });

        // Ambil alamat awal jika koordinat sudah ada
        if (lat !== -6.3483175211230565 || lng !== 106.78427832614517) {
            updateAddress(lat, lng);
        }
    }

    function updateAddress(lat, lng) {
        const latlng = { lat: lat, lng: lng };
        geocoder.geocode({ location: latlng }, function(results, status) {
            if (status === 'OK' && results[0]) {
                document.getElementById('address_display').value = results[0].formatted_address;
            } else {
                document.getElementById('address_display').value = 'Alamat tidak ditemukan';
            }
        });
    }
</script>
@endpush
@extends('template.layout')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">

                    <h4 class="mb-3 fw-semibold">
                        Pilih Bank Sampah Tujuan
                    </h4>

                    <p class="text-muted">
                        Klik pada marker bank sampah di peta, lalu pilih bank tersebut untuk setoran Anda.
                    </p>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button onclick="getUserLocation()" class="btn btn-success">
                            Tampilkan Lokasi Saya
                        </button>
                        <div id="locationStatus" class="small text-muted"></div>
                    </div>

                    <div id="map" style="height: 500px; width: 100%; border-radius: 12px;"></div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
let map;
let userMarker;
let currentInfoWindow = null;
const banks = @json($banks);

function initMap() {
    const defaultLocation = {
        lat: -6.200000,
        lng: 106.816666
    };

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: defaultLocation,
    });

    banks.forEach((bank) => {
        const marker = new google.maps.Marker({
            position: {
                lat: bank.lat,
                lng: bank.lng
            },
            map: map,
            title: bank.name,
            icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/green-dot.png"
            }
        });

        const contentString = `
                <div style="max-width: 260px; padding: 8px;">
                    <h6><strong>${bank.name}</strong></h6>
                    <p>${bank.address || '-'}</p>
                    <p>${bank.operation_hours || '-'}</p>
                    <p>${bank.contact || '-'}</p>
                    <button onclick="pilihBank(${bank.id})"
                        style="background:#198754;color:white;border:none;padding:6px 10px;border-radius:8px;width:100%;">
                        Pilih Bank
                    </button>
                </div>
            `;

        const infoWindow = new google.maps.InfoWindow({
            content: contentString,
        });

        marker.addListener("click", () => {
            if (currentInfoWindow) currentInfoWindow.close();
            infoWindow.open(map, marker);
            currentInfoWindow = infoWindow;
        });
    });
}

function pilihBank(bankId) {
    window.location.href = "{{ route('warga.deposits.create') }}?bank_id=" + bankId;
}

function getUserLocation() {
    const statusDiv = document.getElementById('locationStatus');
    statusDiv.innerHTML = '⏳ Mendeteksi lokasi...';

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                statusDiv.innerHTML = 'Lokasi ditemukan';
                map.panTo(userPos);
                map.setZoom(15);

                if (userMarker) userMarker.setMap(null);

                userMarker = new google.maps.Marker({
                    position: userPos,
                    map: map,
                    title: "Lokasi Anda",
                    icon: {
                        url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                    }
                });

                setTimeout(() => statusDiv.innerHTML = '', 3000);
            },
            () => {
                statusDiv.innerHTML = 'Gagal ambil lokasi';
            }
        );
    } else {
        statusDiv.innerHTML = 'Browser tidak support';
    }
}
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap"></script>

@endsection
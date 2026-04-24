<!DOCTYPE html>
<html>
<head>
    <title>Peta Bank Sampah</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        #map { height: 500px; }
    </style>
</head>
<body>

<h2>Peta Bank Sampah</h2>
<div id="map"></div>

<script>
var map = L.map('map').setView([-6.2, 106.8], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

// ambil dari API Laravel
fetch('/api/banks')
.then(res => res.json())
.then(data => {

    data.forEach(bank => {

        var marker = L.marker([bank.latitude, bank.longitude]).addTo(map);

        marker.bindPopup(`
            <b>${bank.name}</b><br>
            ${bank.address ?? ''}<br>
            Jam: ${bank.operation_hours ?? '-'}<br>
            Kontak: ${bank.contact ?? '-'}<br><br>

            <a href="https://www.google.com/maps?q=${bank.latitude},${bank.longitude}" target="_blank">
                Arahkan ke lokasi
            </a>
        `);

    });

});
</script>

</body>
</html>
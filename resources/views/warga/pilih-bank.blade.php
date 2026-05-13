<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Bank Sampah Tujuan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4 text-gray-600">Klik pada marker bank sampah di peta, lalu pilih bank tersebut untuk
                    setoran Anda.</p>


                <div class="mb-4 flex justify-between items-center">
                    <button onclick="getUserLocation()"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                        📍 Tampilkan Lokasi Saya
                    </button>
                    <div id="locationStatus" class="text-sm text-gray-500"></div>
                </div>

                <!-- Container peta -->
                <div id="map" style="height: 500px; width: 100%; border-radius: 12px;"></div>
            </div>
        </div>
    </div>

    <script>
        let map;
        let userMarker;
        let currentInfoWindow = null;
        const banks = @json($banks);

        function initMap() {
            const defaultLocation = { lat: -6.200000, lng: 106.816666 };
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: defaultLocation,
            });

            // Tambahkan marker untuk setiap bank
            banks.forEach((bank) => {
                const marker = new google.maps.Marker({
                    position: { lat: bank.lat, lng: bank.lng },
                    map: map,
                    title: bank.name,
                    icon: {
                        url: "https://maps.google.com/mapfiles/ms/icons/green-dot.png"
                    }
                });

                // Konten Info Window dengan tombol pilih
                const contentString = `
                    <div style="max-width: 260px; padding: 8px;">
                        <h3 style="font-weight: bold; margin-bottom: 6px;">🏦 ${bank.name}</h3>
                        <p style="margin: 4px 0;">📍 ${bank.address || 'Alamat tidak tersedia'}</p>
                        <p style="margin: 4px 0;">🕒 ${bank.operation_hours || 'Tidak tersedia'}</p>
                        <p style="margin: 4px 0;">📞 ${bank.contact || '-'}</p>
                        <button onclick="pilihBank(${bank.id})" 
                                style="background-color: #2c6e3f; color: white; border: none; padding: 6px 12px; border-radius: 20px; margin-top: 8px; cursor: pointer; width: 100%;">
                            Pilih Bank Ini
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

        // Fungsi pilih bank, redirect ke form setoran dengan bank_id
        function pilihBank(bankId) {
            window.location.href = "{{ route('deposits.create') }}?bank_id=" + bankId;
        }

        // Geolokasi pengguna
        function getUserLocation() {
            const statusDiv = document.getElementById('locationStatus');
            statusDiv.innerHTML = '<span class="text-blue-500"> Mendeteksi lokasi...</span>';
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        const userPos = { lat: userLat, lng: userLng };
                        statusDiv.innerHTML = '<span class="text-green-600">✓ Lokasi ditemukan, menggeser peta...</span>';
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
                        setTimeout(() => { statusDiv.innerHTML = ''; }, 3000);
                    },
                    (error) => {
                        statusDiv.innerHTML = '<span class="text-red-600"> Gagal mengakses lokasi. Pastikan izin diberikan.</span>';
                    }
                );
            } else {
                statusDiv.innerHTML = '<span class="text-red-600"> Browser tidak mendukung geolokasi.</span>';
            }
        }
    </script>

    <!-- Load Google Maps API dengan callback -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap">
    </script>
</x-app-layout>
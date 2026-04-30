<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>EcoCycle - Platform Daur Ulang & Ekonomi Sirkular</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #fafef7;
            color: #1e2f2a;
            scroll-behavior: smooth;
        }
        :root {
            --eco-primary: #0f6e3f;
            --eco-secondary: #2b8c4a;
            --eco-soft: #e3f5e8;
            --eco-dark: #114d2e;
            --eco-muted: #5a7c6a;
            --eco-warm: #fef9e6;
            --eco-border: #d4e2d4;
        }
        .bg-eco-soft { background-color: #eef6ea; }
        .text-eco { color: #0f6e3f; }
        .border-eco-light { border-color: #cde2ce; }
        .hover\:bg-eco-dark:hover { background-color: #0c5835; }
        .shadow-eco { box-shadow: 0 12px 28px -10px rgba(30, 70, 40, 0.12); }
        .card-hover {
            transition: all 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 24px 36px -16px rgba(30, 70, 40, 0.18);
        }

        .navbar-scrolled {
            background-color: rgba(255, 255, 245, 0.96);
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 18px rgba(0,0,0,0.03), 0 1px 0 rgba(86, 128, 86, 0.1);
        }
        .btn-outline-natural {
            border: 1.5px solid #2a7a48;
            background: transparent;
            padding: 8px 22px;
            border-radius: 40px;
            font-weight: 500;
            transition: 0.2s;
            color: #1c613c;
        }
        .btn-outline-natural:hover {
            background: #eef6ea;
            border-color: #1f6b3e;
        }
        .btn-solid-eco {
            background: #117347;
            padding: 10px 28px;
            border-radius: 44px;
            font-weight: 600;
            color: white;
            box-shadow: 0 6px 14px rgba(23, 95, 55, 0.2);
            transition: 0.2s;
        }
        .btn-solid-eco:hover {
            background: #0b5a38;
            transform: translateY(-1px);
        }
        .hero-gradient {
            background: linear-gradient(115deg, #f6fff0 0%, #ecf9e6 100%);
        }
        .img-logo-custom {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 100px;
            box-shadow: 0 5px 12px rgba(0,0,0,0.05);
            border: 2px solid rgba(44, 130, 70, 0.2);
        }
        /* testimonial card */
        .testi-card {
            background: #ffffffdd;
            backdrop-filter: blur(2px);
            border: 1px solid #e0f0df;
        }
        .footer-bg {
            background: #112b1f;
        }
        @keyframes gentleFloat {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
        .float-leaf {
            animation: gentleFloat 5s ease-in-out infinite;
        }
        section {
            scroll-margin-top: 80px;
        }
        .hover-grow {
            transition: transform 0.2s;
        }
        .hover-grow:hover {
            transform: scale(1.01);
        }
        /* tambahan untuk logo bulat */
        .rounded-logo {
            border-radius: 100%;
            object-fit: cover;
            width: 100%;
            height: 100%;
            box-shadow: 0 20px 35px -12px rgba(0,0,0,0.15);
            border: 3px solid white;
        }
    </style>
</head>
<body class="antialiased">

   
    <header class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-sm border-b border-[#ddebe0] shadow-sm" id="mainNav">
        <div class="max-w-7xl mx-auto px-5 lg:px-8 py-3 flex flex-wrap items-center justify-between">
            <div class="flex items-center gap-2">
                <div>
                    <span class="text-xl font-bold tracking-tight" style="color: #156b41;">Eco<span style="color: #44a36f;">Cycle</span></span>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-8 font-medium text-[#2c5a44]">
                <a href="#beranda" class="hover:text-[#0f6e3f] transition">Beranda</a>
                <a href="#layanan" class="hover:text-[#0f6e3f] transition">Layanan</a>
                <a href="#tentang" class="hover:text-[#0f6e3f] transition">Tentang</a>
                <a href="#hubungi" class="hover:text-[#0f6e3f] transition">Hubungi Kami</a>
            </div>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        @if(Auth::user()->role == "mitra")
                        <a href="{{ url('/dashboard/mitra') }}" class="text-sm font-semibold text-gray-700 hover:text-[#117347] transition px-3 py-2">Dashboard</a>
                        @elseif(Auth::user()->role == "warga")
                        <a href="{{ url('/warga/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-[#117347] transition px-3 py-2">Dashboard</a>
                        @else
                        <a href="{{ url('/dashboard/admin') }}" class="text-sm font-semibold text-gray-700 hover:text-[#117347] transition px-3 py-2">Dashboard</a>
                        @endif                    
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold px-5 py-2 rounded-full border-2 border-[#117347] text-[#117347] hover:bg-[#eef6ea] transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-[#117347] hover:bg-[#0b5a38] px-5 py-2 rounded-full transition shadow-sm">Register</a>
                        @endif
                    @endauth
                @endif
                <button id="menuBtn" class="block md:hidden text-2xl text-[#2b6743] focus:outline-none ml-2">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <div id="mobileMenu" class="hidden md:hidden bg-white/95 backdrop-blur-md px-5 pb-5 flex flex-col space-y-3 border-t border-[#cde0d1] mt-1">
            <a href="#beranda" class="py-2 text-[#2c5a44] font-medium hover:text-[#0f6e3f]">Beranda</a>
            <a href="#layanan" class="py-2 text-[#2c5a44] font-medium hover:text-[#0f6e3f]">Layanan</a>
            <a href="#tentang" class="py-2 text-[#2c5a44] font-medium hover:text-[#0f6e3f]">Tentang</a>
            <a href="#hubungi" class="py-2 text-[#2c5a44] font-medium hover:text-[#0f6e3f]">Hubungi Kami</a>
            <div class="pt-2 flex flex-col gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-center text-sm font-semibold text-gray-700 py-2">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-center text-sm font-semibold border border-[#117347] rounded-full py-2 text-[#117347]">Log in</a>
                    <a href="{{ route('register') }}" class="text-center text-sm font-semibold bg-[#117347] text-white rounded-full py-2">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="pt-20">
        <section id="beranda" class="hero-gradient min-h-[90vh] flex items-center px-5 md:px-12">
            <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center py-12">
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 bg-white/70 backdrop-blur-sm rounded-full px-4 py-1.5 border border-[#cbe5cf] text-sm font-medium text-[#286e46] mb-5">
                        <i class="fas fa-rotate-right text-xs"></i> Zero waste · Circular economy
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight text-[#175f38]">Ubah sampah jadi <span class="text-[#44a36f]">berkah</span> bersama EcoCycle</h1>
                    <p class="text-gray-600 mt-5 text-lg max-w-lg leading-relaxed">Solusi daur ulang cerdas & layanan pengelolaan limbah berkelanjutan. Bersama kita ciptakan lingkungan sehat tanpa limbah berlebih.</p>
                    
                    <div class="flex gap-7 mt-12 pt-2 flex-wrap">
                        <div><span class="font-extrabold text-2xl text-[#0e6b41]">2.5K+</span> <span class="text-gray-500 text-sm">Ton daur ulang</span></div>
                        <div><span class="font-extrabold text-2xl text-[#0e6b41]">120+</span> <span class="text-gray-500 text-sm">Mitra bisnis</span></div>
                        <div><span class="font-extrabold text-2xl text-[#0e6b41]">98%</span> <span class="text-gray-500 text-sm">Kepuasan pelanggan</span></div>
                    </div>
                </div>

    
                <div class="order-1 md:order-2 flex justify-center relative">
                    <div class="bg-[#daf1df] w-72 h-72 md:w-96 md:h-96 rounded-full absolute -z-0 blur-3xl opacity-30"></div>
                    <div class="relative z-2 bg-white rounded-3xl shadow-2xl p-4 border-4 border-white/70" style="border-radius: 2rem;">
                        <img src="{{ asset('Stisla/dist/assets/img/logoeco.jpeg') }}" alt="EcoCycle Logo" class="rounded-2xl w-64 h-64 md:w-80 md:h-80 object-cover" style="border-radius: 1.5rem;" onerror="this.src='https://placehold.co/400x400/eef5ea/2e7d5a?text=EcoCycle'">
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="py-20 px-5 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-14">
                    <span class="bg-[#e4f3e4] text-[#1b7042] px-4 py-1.5 rounded-full text-sm font-semibold inline-block mb-3">🌿 Solusi sirkular</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-[#164e32]">Layanan Unggulan EcoCycle</h2>
                    <div class="w-24 h-1 bg-[#5bb47b] mx-auto mt-4 rounded-full"></div>
                    <p class="text-gray-600 max-w-2xl mx-auto mt-5">Dari pengumpulan sampah hingga produk daur ulang premium — kami wujudkan ekonomi sirkular.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-[#fefef7] border border-[#deecde] rounded-3xl p-6 card-hover transition-all shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-[#e0f5e6] flex items-center justify-center mb-5"><i class="fas fa-dumpster-fire text-2xl text-[#2c8c51]"></i></div>
                        <h3 class="text-xl font-bold text-[#1b613e]">Bank Sampah Digital</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Setor sampah anorganik, dapatkan poin & cashback. Mudah, transparan, dan terintegrasi mitra daur ulang.</p>
                    </div>
                    <div class="bg-[#fefef7] border border-[#deecde] rounded-3xl p-6 card-hover transition-all shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-[#e0f5e6] flex items-center justify-center mb-5"><i class="fas fa-seedling text-2xl text-[#2c8c51]"></i></div>
                        <h3 class="text-xl font-bold text-[#1b613e]">Kompos & Ecoenzyme</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Ubah sisa organik menjadi pupuk bernilai. Pelatihan dan layanan pengolahan kompos skala rumah tangga & industri.</p>
                    </div>
                    <div class="bg-[#fefef7] border border-[#deecde] rounded-3xl p-6 card-hover transition-all shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-[#e0f5e6] flex items-center justify-center mb-5"><i class="fas fa-boxes text-2xl text-[#2c8c51]"></i></div>
                        <h3 class="text-xl font-bold text-[#1b613e]">Material Recovery</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Pengolahan plastik, kertas, logam menjadi bahan baku sekunder berkualitas untuk industri hijau.</p>
                    </div>
                    <div class="bg-[#fefef7] border border-[#deecde] rounded-3xl p-6 card-hover transition-all shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-[#e0f5e6] flex items-center justify-center mb-5"><i class="fas fa-chalkboard-user text-2xl text-[#2c8c51]"></i></div>
                        <h3 class="text-xl font-bold text-[#1b613e]">Edukasi & Sertifikasi</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Pelatihan pengelolaan limbah untuk komunitas & perusahaan. Dapatkan sertifikasi bebas sampah.</p>
                    </div>
                    <div class="bg-[#fefef7] border border-[#deecde] rounded-3xl p-6 card-hover transition-all shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-[#e0f5e6] flex items-center justify-center mb-5"><i class="fas fa-truck-fast text-2xl text-[#2c8c51]"></i></div>
                        <h3 class="text-xl font-bold text-[#1b613e]">Penjemputan Terjadwal</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Layanan jemput sampah daur ulang langsung dari rumah atau kantor. Praktis & tepat waktu.</p>
                    </div>
                    <div class="bg-[#fefef7] border border-[#deecde] rounded-3xl p-6 card-hover transition-all shadow-sm">
                        <div class="w-14 h-14 rounded-2xl bg-[#e0f5e6] flex items-center justify-center mb-5"><i class="fas fa-hand-holding-heart text-2xl text-[#2c8c51]"></i></div>
                        <h3 class="text-xl font-bold text-[#1b613e]">Konsultasi Hijau</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Dampingi perjalanan nol limbah Anda. Analisis waste stream & rekomendasi ramah lingkungan.</p>
                    </div>
                </div>
            </div>
        </section>


        <section id="tentang" class="py-20 px-5 bg-[#f7fcf3]">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-16 items-center">
                <div class="flex-1 text-center lg:text-left">
                    <span class="bg-white/60 px-4 py-1 rounded-full text-sm font-semibold text-[#1c7041] border border-[#cce3cf] inline-block mb-4">♻️ Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-[#164e32] leading-tight">Mengubah pola pikir <br> dari <span class="border-b-4 border-[#8bc34a]">"buang"</span> menjadi <span class="text-[#3aae66]">"berdayakan"</span></h2>
                    <p class="text-gray-600 mt-6 text-lg leading-relaxed">EcoCycle hadir sejak 2022 sebagai gerakan nyata melawan krisis limbah. Kami percaya bahwa setiap material memiliki siklus hidup kedua. Dengan teknologi tepat guna dan kolaborasi dengan komunitas lokal, kami telah mengolah lebih dari 2.500 ton sampah menjadi produk bernilai ekonomi.</p>
                    <div class="flex flex-wrap gap-5 mt-8 justify-center lg:justify-start">
                        <div><i class="fas fa-check-circle text-[#267e4a]"></i> <span class="font-medium">Transparansi penuh</span></div>
                        <div><i class="fas fa-check-circle text-[#267e4a]"></i> <span class="font-medium">Berbasis masyarakat</span></div>
                        <div><i class="fas fa-check-circle text-[#267e4a]"></i> <span class="font-medium">Terakreditasi LHK</span></div>
                    </div>
                    <a href="#hubungi" class="inline-flex items-center gap-2 mt-8 bg-transparent border border-[#208054] text-[#1b6e41] font-semibold px-7 py-3 rounded-full hover:bg-[#eaf7e3] transition">Kolaborasi dengan kami <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="flex-1 flex justify-center relative">
                    <div class="bg-[#dcefe0] rounded-[3rem] p-3 shadow-xl">
                        <img src="{{ asset('Stisla/dist/assets/img/logoeco.jpeg') }}" alt="EcoCycle Circular Economy" class="rounded-3xl w-full max-w-sm shadow-md border-2 border-white" style="aspect-ratio: 1/1; object-fit: cover;" onerror="this.src='https://placehold.co/400x400/eef5ea/2e7d5a?text=EcoCycle'">
                    </div>
                </div>
            </div>
        </section>



        <section id="hubungi" class="py-20 px-5 bg-[#eef6ea]">
            <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden md:flex">
                <div class="md:w-1/2 bg-[#18633e] p-8 text-white flex flex-col justify-center">
                    <h3 class="text-2xl font-bold mb-4">🌱 Mari berkolaborasi</h3>
                    <p class="mb-6 leading-relaxed">Siap mengurangi limbah dan menciptakan dampak nyata? Hubungi tim EcoCycle untuk konsultasi atau kemitraan.</p>
                    <div class="flex gap-3 items-center mb-3"><i class="fas fa-phone-alt"></i> <span>+62 857 7140 0670</span></div>
                    <div class="flex gap-3 items-center mb-3"><i class="fas fa-envelope"></i> <span>hello@ecocycle.id</span></div>
                    <div class="flex gap-3 items-center"><i class="fas fa-map-marker-alt"></i> <span>Jakarta - Depok</span></div>
                </div>
                <div class="md:w-1/2 p-8">
                    <h4 class="text-xl font-bold text-[#175d38] mb-4">Kirim pesan langsung</h4>
                    <form>
                        <input type="text" placeholder="Nama lengkap" class="w-full mb-4 border border-[#d2e3d2] rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[#76b37e]">
                        <input type="email" placeholder="Email aktif" class="w-full mb-4 border border-[#d2e3d2] rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[#76b37e]">
                        <textarea rows="3" placeholder="Ceritakan kebutuhan Anda..." class="w-full mb-5 border border-[#d2e3d2] rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[#76b37e]"></textarea>
                        <button type="button" class="bg-[#176e42] text-white px-7 py-3 rounded-xl font-semibold hover:bg-[#0d5535] transition w-full">Kirim Konsultasi →</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-bg text-gray-300 py-12 px-5">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-3"><span class="font-bold text-white text-xl">EcoCycle</span></div>
                <p class="text-sm text-gray-400">Mendorong ekonomi sirkular dan pengelolaan limbah modern untuk Indonesia hijau.</p>
            </div>
            <div><h5 class="font-semibold text-white mb-3">Tautan</h5><ul class="space-y-2 text-sm"><li><a href="#beranda" class="hover:text-[#b9e0b0]">Beranda</a></li><li><a href="#layanan" class="hover:text-[#b9e0b0]">Layanan</a></li><li><a href="#tentang" class="hover:text-[#b9e0b0]">Tentang</a></li><li><a href="#hubungi" class="hover:text-[#b9e0b0]">Hubungi Kami</a></li></ul></div>
            <div><h5 class="font-semibold text-white mb-3">Legal</h5><ul class="space-y-2 text-sm"><li><a href="#" class="hover:text-[#b9e0b0]">Kebijakan Privasi</a></li><li><a href="#" class="hover:text-[#b9e0b0]">Syarat & Ketentuan</a></li><li><a href="#" class="hover:text-[#b9e0b0]">Sertifikasi</a></li></ul></div>
            <div><h5 class="font-semibold text-white mb-3">Ikuti Kami</h5><div class="flex gap-4 text-xl"><i class="fab fa-instagram hover:text-[#b1e0a5] cursor-pointer"></i><i class="fab fa-twitter hover:text-[#b1e0a5] cursor-pointer"></i><i class="fab fa-linkedin hover:text-[#b1e0a5] cursor-pointer"></i><i class="fab fa-youtube hover:text-[#b1e0a5] cursor-pointer"></i></div><p class="text-xs text-gray-500 mt-4">© 2026 EcoCycle — Daur ulang untuk masa depan</p></div>
        </div>
    </footer>

    <script>
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 15) nav.classList.add('navbar-scrolled');
            else nav.classList.remove('navbar-scrolled');
        });
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if(menuBtn){
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if(href === "#" || !href.startsWith("#")) return;
                const target = document.querySelector(href);
                if(target){
                    e.preventDefault();
                    target.scrollIntoView({behavior: 'smooth', block: 'start'});
                    if(mobileMenu && !mobileMenu.classList.contains('hidden')) mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
@extends('template.layout')

@section('title', 'AI Scan Sampah')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4>AI Scan - Identifikasi Jenis Sampah</h4>
                <p class="text-muted mb-0">Gunakan kamera untuk mendeteksi jenis sampah secara otomatis</p>
            </div>
            <div class="card-body text-center">
                <div id="webcam-container" class="d-flex justify-content-center"></div>
                <div id="label-container" class="mt-3 row"></div>
                <div class="mt-3">
                    <button id="captureBtn" class="btn btn-primary btn-lg">
                        <i class="fas fa-camera"></i> Ambil & Prediksi
                    </button>
                </div>
            </div>
        </div>

        <div id="formDeposit" class="card mt-4" style="display: none;">
            <div class="card-header">
                <h4>Form Setoran Sampah</h4>
            </div>
            <div class="card-body">
                <form id="depositForm" action="{{ route('deposits.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="waste_type_id" id="waste_type_id">
                    <input type="hidden" name="ai_scanned" value="1">
        
                    <div class="form-group">
                        <label>Jenis Sampah (Hasil AI)</label>
                        <input type="text" id="waste_name" class="form-control" readonly>
                    </div>
        
                    <div class="form-group">
                        <label>Pilih Bank Sampah Tujuan</label>
                        <select name="bank_id" id="bank_id" class="form-control" required>
                            <option value="">-- Pilih Bank --</option>
                            @foreach($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }} - {{ $bank->address ?? 'Alamat tidak tersedia' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="form-group">
                        <label>Berat (kg)</label>
                        <input type="number" name="weight_kg" id="weight_kg" step="0.1" class="form-control" required>
                    </div>
        
                    <div class="form-group">
                        <label>Tanggal Setor</label>
                        <input type="date" name="deposit_date" id="deposit_date" class="form-control" required>
                    </div>
        
                    <div class="form-group">
                        <label>Catatan (opsional)</label>
                        <textarea name="notes" class="form-control" rows="2"
                            placeholder="Misal: kemasan sudah dicuci"></textarea>
                    </div>
        
                    <button type="submit" class="btn btn-success">Simpan Setoran</button>
                    <button type="button" id="cancelForm" class="btn btn-secondary">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
<script>

    const URL = "https://teachablemachine.withgoogle.com/models/eU6-dBztJ/";

    let model, webcam, labelContainer, maxPredictions;
    let isPredicting = false;
    let lastPrediction = null;

    async function init() {
        const modelURL = URL + "model.json";
        const metadataURL = URL + "metadata.json";

        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses();

        // Setup webcam
        const flip = true;
        webcam = new tmImage.Webcam(300, 300, flip);
        await webcam.setup();
        await webcam.play();
        window.requestAnimationFrame(loop);

        // Tambahkan canvas webcam ke container
        const webcamContainer = document.getElementById("webcam-container");
        webcamContainer.innerHTML = '';
        webcamContainer.appendChild(webcam.canvas);

        // Buat container label
        labelContainer = document.getElementById("label-container");
        labelContainer.innerHTML = '';
        for (let i = 0; i < maxPredictions; i++) {
            const div = document.createElement('div');
            div.className = 'col-6 col-md-4 mb-2';
            div.innerHTML = `<div class="alert alert-secondary">Loading...</div>`;
            labelContainer.appendChild(div);
        }
    }

    async function loop() {
        webcam.update();
        if (!isPredicting) {
            await predict();
        }
        window.requestAnimationFrame(loop);
    }

    async function predict() {
        const prediction = await model.predict(webcam.canvas);
        // Tampilkan hasil prediksi
        for (let i = 0; i < maxPredictions; i++) {
            const percent = (prediction[i].probability * 100).toFixed(1);
            const className = prediction[i].className;
            const bgColor = prediction[i].probability > 0.6 ? 'success' : 'secondary';
            labelContainer.childNodes[i].innerHTML = `
                <div class="alert alert-${bgColor} text-center">
                    <strong>${className}</strong><br>
                    ${percent}%
                </div>
            `;
        }
        // Simpan prediksi terbaik
        let best = prediction.reduce((a, b) => a.probability > b.probability ? a : b);
        lastPrediction = {
            className: best.className,
            probability: best.probability
        };
    }

    // Tombol ambil foto & isi form
    document.getElementById('captureBtn').addEventListener('click', () => {
        if (!lastPrediction || lastPrediction.probability < 0.6) {
            alert('Tidak yakin dengan objek yang terdeteksi (confidence < 60%). Coba lagi dengan pencahayaan cukup dan objek lebih jelas.');
            return;
        }

        // Kirim nama kelas ke server untuk mapping waste_type_id
        fetch("{{ route('warga.ai.map') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ className: lastPrediction.className })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('waste_type_id').value = data.waste_type_id;
                document.getElementById('waste_name').value = data.waste_name;
                document.getElementById('formDeposit').style.display = 'block';
                document.getElementById('formDeposit').scrollIntoView({ behavior: 'smooth' });
            } else {
                alert('Kategori sampah tidak dikenali di sistem. Silakan pilih manual di form setoran biasa.');
                window.location.href = "{{ route('deposits.create') }}";
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });

    // Cancel form
    document.getElementById('cancelForm')?.addEventListener('click', () => {
        document.getElementById('formDeposit').style.display = 'none';
    });

    // Set tanggal default hari ini
    document.getElementById('deposit_date').valueAsDate = new Date();

    // Inisialisasi AI
    init();
</script>
@endpush
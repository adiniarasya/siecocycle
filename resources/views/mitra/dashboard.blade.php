@extends('template.layout')

@section('title', 'Dashboard')

@section('content')

<style>
    :root {
        --primary-navy: #0f172a;
        --border-color: #e2e8f0;
        --text-main: #334155;
        --text-muted: #64748b;
    }

    .card-custom {
        border-radius: 15px;
        border: none;
        color: white;
    }

    .card-blue { background: #3b82f6; }
    .card-red { background: #ef4444; }
    .card-yellow { background: #f59e0b; }

    .btn-primary-custom {
        background-color: var(--primary-navy);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-primary-custom:hover {
        background-color: #1e293b;
        color: white;
    }
</style>

<div class="container-fluid">

    <!-- CARD SUMMARY -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-custom card-blue p-3">
                <h6>Pending</h6>
                <h3>{{ $totalPending ?? 0 }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom card-red p-3">
                <h6>Terverifikasi</h6>
                <h3>{{ $totalVerified ?? 0 }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom card-yellow p-3">
                <h6>Total Sampah Masuk</h6>
                <h3>{{ $totalSampah ?? 0 }} Kg</h3>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Warga</th>
                            <th>Jenis Sampah</th>
                            <th>Berat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($deposits ?? [] as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>

                            <!-- WARGA -->
                            <td>
                                {{ $item->user->name ?? 'Tidak ada' }}
                            </td>

                            <!-- JENIS SAMPAH -->
                            <td>
                                {{ $item->wasteType->name ?? 'Tidak ada' }}
                            </td>

                            <!-- BERAT -->
                            <td class="text-center">
                                {{ $item->weight_kg ?? 0 }} Kg
                            </td>

                            <!-- TANGGAL -->
                            <td class="text-center">
                                {{ $item->deposit_date 
                                    ? \Carbon\Carbon::parse($item->deposit_date)->format('d M Y') 
                                    : '-' }}
                            </td>

                            <!-- STATUS -->
                           <td class="text-center">

    @if($item->status == 'pending')
        <form action="{{ url('deposit/'.$item->id.'/decision') }}" method="POST" class="d-inline">
            @csrf

            <!-- REJECT -->
            <button type="button" 
                    data-decision="rejected"
                    class="btn btn-sm btn-danger btn-decision me-1">
                ❌
            </button>

            <!-- APPROVE -->
            <button type="button" 
                    data-decision="verified"
                    class="btn btn-sm btn-success btn-decision">
                ✔
            </button>
        </form>

    @elseif($item->status == 'verified')
        <span class="badge bg-success">Verified</span>

    @else
        <span class="badge bg-danger">Rejected</span>
    @endif

</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data setoran
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btn-decision').forEach(function(btn){
    btn.addEventListener('click', function(){
        let form = this.closest('form');
        let decision = this.dataset.decision;

        if(decision === 'verified'){
            Swal.fire({
                title: 'Verifikasi Setoran?',
                text: 'Data akan disetujui',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Ya, setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed){
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'status';
                    input.value = decision;
                    form.appendChild(input);

                    form.submit();
                }
            });

        } else {
            Swal.fire({
                title: 'Tolak Setoran?',
                text: 'Data akan ditolak',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed){
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'status';
                    input.value = decision;
                    form.appendChild(input);

                    form.submit();
                }
            });
        }
    });
});
</script>
@endsection
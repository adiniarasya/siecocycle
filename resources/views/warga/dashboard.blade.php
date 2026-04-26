@extends('template/layout')
@section('content')
@section('title', 'Dashboard')

<div class="row align-items-stretch mb-5">

  <div class="col-lg-4 col-md-6 col-12">
    <div class="card custom-card text-white bg-primary h-100">
      <div class="card-body d-flex align-items-center">
        <div class="mr-3">
          <i class="fas fa-trash"></i>
        </div>
        <div>
          <div class="card-title mb-1">Total Sampah Terkelola</div>
          <h4 class="mb-0">10</h4>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-12">
    <div class="card custom-card text-white bg-danger h-100">
      <div class="card-body d-flex align-items-center">
        <div class="mr-3">
          <i class="fas fa-cloud"></i>
        </div>
        <div>
          <div class="card-title mb-1">Jumlah CO₂ yang Berhasil Dikurangi</div>
          <h4 class="mb-0">42</h4>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-12">
    <div class="card custom-card text-white bg-warning h-100">
      <div class="card-body d-flex align-items-center">
        <div class="mr-3">
          <i class="fas fa-coins"></i>
        </div>
        <div>
          <div class="card-title mb-1">Reward / Poin</div>
          <h4 class="mb-0">1,201</h4>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="card">
    <div class="card-header">
        <h4>Riwayat Setoran</h4>
        <a href="#" class="btn btn-primary btn-sm ml-auto"><i class="fas fa-plus"></i> Catat Setoran</a>
    </div>
    <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped ">
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Jenis</th>
                          <th>Berat</th>
                          <th>Poin</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2017-01-09</td>
                          <td>Plastik</td>
                          <td>1 Kg</td>
                          <td>100</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>2017-01-09</td>
                          <td>Kertas</td>
                          <td>2 Kg</td>
                          <td>400</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>2017-01-09</td>
                          <td>Plastik</td>
                          <td>1 Kg</td>
                          <td>500</td>
                        </tr>
                      </table>
                    </div>
                  </div>
</div>

@endsection
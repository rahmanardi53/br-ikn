@extends('layouts.master')

@section('content')

<div class="content-wrapper">
<div class="row">
<div class="col-md-12">
<div class="card">
            <div class="card-body">
                <p class="card-title">Data Absensi</p>
                <p class="text-muted mb-3">Pilih Hari Senin</p>


<form method="GET" class="row mb-4">
    <div class="col-md-3">
         <input type="date" name="senin" class="form-control" value="{{ $senin }}" required>
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
    </div>
</form>
<div class="table-responsive">
 <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Total Jam Kerja</th>
                <th>Gaji Pokok</th>
                <th>Bonus</th>
                <th>Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['total_jam'], 2) }} jam</td>
                    <td>Rp{{ number_format($item['gaji_pokok'], 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item['bonus'], 0, ',', '.') }}</td>
                    <td><strong>Rp{{ number_format($item['total_gaji'], 0, ',', '.') }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
<style>
    .sticky-col {
        position: sticky;
        left: 0;
        z-index: 1;
    }

    /* Biar header nama di atas semua */
    .sticky-col:first-child {
        z-index: 2;
    }

    /* Optional: supaya kelihatan bersih */
    .table-responsive {
        overflow-x: auto;
    }
</style>

</div>
</div>
</div>
</div>
</div>
</div>
@endsection


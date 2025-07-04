@extends('layouts.master')

@section('content')
<div class="content-wrapper">
<div class="row">
<div class="col-md-12">
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <p class="card-title">Data Barang</p>
        <p class="text-muted mb-3">Berikut adalah daftar barang yang tersedia.</p>

<a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">+ Tambah Barang</a>
<div class="table-responsive">

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Komisi</th>
            <th width="10%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangs as $barang)
        <tr>
            <td>{{ $barang->nama_barang }}</td>
            <td>Rp. {{ number_format($barang->harga) }}</td>
            <td>Rp. {{ number_format($barang->komisi) }}</td>
            <td>
                <!-- Edit -->
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBarangModal{{ $barang->id }}">Edit</button>

                <!-- Hapus -->
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusBarangModal{{ $barang->id }}">Hapus</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahBarangModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('barang.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Komisi</label>
            <input type="number" name="komisi" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="submit">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

@foreach($barangs as $barang)
<!-- Modal Edit -->
<div class="modal fade" id="editBarangModal{{ $barang->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('barang.update', $barang->id) }}">
      @csrf @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
          </div>
          <div class="mb-2">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $barang->harga }}" required>
          </div>
          <div class="mb-2">
            <label>Komisi</label>
            <input type="number" name="komisi" class="form-control" value="{{ $barang->komisi }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-warning" type="submit">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="hapusBarangModal{{ $barang->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('barang.destroy', $barang->id) }}">
      @csrf @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus barang <strong>{{ $barang->nama_barang }}</strong>?</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="submit">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach
@endsection
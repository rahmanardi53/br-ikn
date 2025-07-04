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
        <p class="card-title">Master Gaji</p>
        <p class="text-muted mb-3">Berikut adalah daftar master gaji karyawan.</p>

<a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahGajiModal">+ Tambah Gaji</a>
<div class="table-responsive">

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Karyawan</th>
            <th>Gaji Pokok</th>
            <th width="10%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gajis as $gaji)
        <tr>
            <td>{{ $gaji->user->name }}</td>
            <td>Rp. {{ number_format($gaji->gaji_pokok) }}</td>
            <td>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editGajiModal{{ $gaji->id }}">Edit</button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusGajiModal{{ $gaji->id }}">Hapus</button>
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

{{-- Modal Tambah --}}
<div class="modal fade" id="tambahGajiModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('master-gaji.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Gaji</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Karyawan</label>
            <select name="user_id" class="form-control" required>
              <option value="">-- Pilih Karyawan --</option>
              @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-2">
            <label>Gaji Pokok</label>
            <input type="number" name="gaji_pokok" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="submit">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Modal Edit & Hapus --}}
@foreach($gajis as $gaji)
<div class="modal fade" id="editGajiModal{{ $gaji->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('master-gaji.update', $gaji->id) }}">
      @csrf @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Gaji</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Karyawan</label>
            <input type="text" class="form-control" value="{{ $gaji->user->name }}" readonly>
          </div>
          <div class="mb-2">
            <label>Gaji Pokok</label>
            <input type="number" name="gaji_pokok" class="form-control" value="{{ $gaji->gaji_pokok }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-warning" type="submit">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="hapusGajiModal{{ $gaji->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('master-gaji.destroy', $gaji->id) }}">
      @csrf @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus gaji untuk <strong>{{ $gaji->user->name }}</strong>?</p>
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

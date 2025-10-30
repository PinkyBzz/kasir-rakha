@extends('layouts.app')

@section('content')
<h3 class="mb-3">Tambah Pengeluaran</h3>
<form method="POST" action="{{ route('expenses.store') }}">@csrf
  <div class="row g-3" style="max-width:600px;">
    <div class="col-md-4">
      <label class="form-label">Tanggal</label>
      <input type="date" name="date" class="form-control" required>
    </div>
    <div class="col-md-8">
      <label class="form-label">Deskripsi</label>
      <input type="text" name="description" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Jumlah</label>
      <input type="number" name="amount" class="form-control" min="0" step="0.01" required>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection

@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Pengeluaran</h3>
  <a href="{{ route('expenses.create') }}" class="btn btn-primary">Tambah</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Tanggal</th><th>Deskripsi</th><th>Jumlah</th><th>Aksi</th></tr></thead>
  <tbody>
    @foreach($expenses as $e)
      <tr>
        <td>{{ $e->date->format('d M Y') }}</td>
        <td>{{ $e->description }}</td>
        <td>Rp {{ number_format($e->amount,0,',','.') }}</td>
        <td>
          <form method="POST" action="{{ route('expenses.destroy', $e) }}">@csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="mt-2">Total: <strong>Rp {{ number_format($total,0,',','.') }}</strong></div>
{{ $expenses->links() }}
@endsection

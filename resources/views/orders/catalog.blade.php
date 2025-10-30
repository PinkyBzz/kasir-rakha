@extends('layouts.app')

@section('content')
<h3 class="mb-3">Katalog Produk</h3>
<div class="row row-cols-1 row-cols-md-4 g-3">
  @foreach($products as $p)
  <div class="col">
    <div class="card product-card h-100">
      <img src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/300x200?text=No+Image' }}" class="card-img-top" alt="{{ $p->name }}">
      <div class="card-body d-flex flex-column">
        <h6 class="card-title">{{ $p->name }}</h6>
        <div class="mb-2">Rp {{ number_format($p->final_price,0,',','.') }} <small class="text-muted">@if($p->discount_type!='none')<del>Rp {{ number_format($p->price,0,',','.') }}</del>@endif</small></div>
        <form method="POST" action="{{ route('cart.add', $p) }}" class="mt-auto">@csrf
          <div class="input-group">
            <input type="number" name="qty" class="form-control" min="1" value="1">
            <button class="btn btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 fw-bold">Katalog Produk</h3>
  <div class="d-flex gap-2">
    @if(auth()->check() && in_array(auth()->user()->role, ['admin','cashier']))
      <a href="{{ route('products.create') }}" class="btn btn-outline-secondary"><i class="bi bi-plus-circle me-2"></i>Tambah Produk</a>
    @endif
    <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary"><i class="bi bi-cart3 me-2"></i>Lihat Keranjang</a>
  </div>
  
</div>
<div class="row row-cols-2 row-cols-md-4 g-3">
  @foreach($products as $p)
  <div class="col reveal">
    <div class="card product-card h-100">
      @php
        $imgUrl = $p->image_path ? route('media.show', ['path' => $p->image_path]) : 'https://via.placeholder.com/300x200?text=No+Image';
      @endphp
      <img src="{{ $imgUrl }}" class="card-img-top" alt="{{ $p->name }}">
      <div class="card-body d-flex flex-column">
        <h6 class="card-title fw-semibold">{{ $p->name }}</h6>
        <div class="mb-2"><span class="price">Rp {{ number_format($p->final_price,0,',','.') }}</span> <small class="text-muted">@if($p->discount_type!='none')<del>Rp {{ number_format($p->price,0,',','.') }}</del>@endif</small></div>
        <form method="POST" action="{{ route('cart.add', $p) }}" class="mt-auto">@csrf
          <div class="input-group">
            <input type="number" name="qty" class="form-control" min="1" value="1" style="max-width: 90px;">
            <button class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection

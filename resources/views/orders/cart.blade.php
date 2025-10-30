@extends('layouts.app')

@section('content')
<div class="mb-4">
  <h2 class="fw-bold mb-1"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h2>
  <p class="text-muted">Review pembelian Anda sebelum checkout</p>
</div>

@if(empty($cart))
  <div class="card fade-in">
    <div class="card-body text-center py-5">
      <i class="bi bi-cart-x" style="font-size: 5rem; opacity: 0.2;"></i>
      <h5 class="mt-3 mb-2">Keranjang Kosong</h5>
      <p class="text-muted mb-4">Belum ada produk di keranjang Anda</p>
      <a href="{{ route('shop.catalog') }}" class="btn btn-primary">
        <i class="bi bi-bag me-2"></i>Mulai Belanja
      </a>
    </div>
  </div>
@else
  <div class="card fade-in mb-4">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover table-sm mb-0 align-middle">
          <thead>
            <tr>
              <th class="ps-4">Produk</th>
              <th class="text-center">Qty</th>
              <th class="text-end">Harga Satuan</th>
              <th class="text-end pe-4">Total</th>
            </tr>
          </thead>
          <tbody>
            @php($grand=0)
            @foreach($products as $p)
              @php($qty = $cart[$p->id])
              @php($unit = $p->discount_type=='percent' ? $p->price*(1-$p->discount_value/100) : ($p->discount_type=='nominal'? max(0,$p->price-$p->discount_value) : $p->price))
              @php($total = $unit * $qty)
              @php($grand += $total)
              <tr>
                <td class="ps-4">
                  <div class="d-flex align-items-center">
                    <div class="me-3" style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                      <img src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/60' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                      <div class="fw-semibold">{{ $p->name }}</div>
                      @if($p->discount_type!='none')
                        <span class="badge bg-danger" style="font-size: 0.7rem;"><i class="bi bi-percent"></i> Diskon</span>
                      @endif
                    </div>
                  </div>
                </td>
                <td class="text-center align-middle">
                  <span class="badge bg-dark" style="font-size: .9rem; padding: .4rem .8rem;">{{ $qty }}</span>
                </td>
                <td class="text-end align-middle fw-semibold">Rp {{ number_format($unit,0,',','.') }}</td>
                <td class="text-end pe-4 align-middle fw-bold" style="font-size: 1.05rem; color:#0f766e;">Rp {{ number_format($total,0,',','.') }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot style="background: linear-gradient(180deg, #f8f9fa 0%, white 100%);">
            <tr>
              <td colspan="3" class="text-end fs-5 fw-bold ps-4" style="padding: 1.5rem;">Grand Total</td>
              <td class="text-end pe-4 fs-4 fw-bold" style="padding: 1.5rem; color: #0f766e;">Rp {{ number_format($grand,0,',','.') }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  
  <div class="text-end">
    <a class="btn btn-success px-4 py-2" href="{{ route('checkout.form') }}"><i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout</a>
  </div>
@endif
@endsection

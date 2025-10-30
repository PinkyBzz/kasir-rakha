@extends('layouts.app')

@section('content')
<h3 class="mb-3">Checkout</h3>
<form method="POST" action="{{ route('checkout.process') }}">@csrf
  <div class="mb-3">
    <label class="form-label">Tipe Belanja</label>
    <select name="order_type" class="form-select" id="order_type">
      <option value="in_store">Sudah di Toko</option>
      <option value="pickup_later">Ambil Nanti</option>
    </select>
  </div>
  <div class="mb-3" id="pickup_group" style="display:none;">
    <label class="form-label">Jam Ambil</label>
    <input type="datetime-local" name="pickup_at" class="form-control">
  </div>
  <button class="btn btn-primary">Selesaikan Transaksi</button>
</form>
<script>
const select = document.getElementById('order_type');
const group = document.getElementById('pickup_group');
function toggle(){ group.style.display = select.value==='pickup_later' ? 'block' : 'none'; }
select.addEventListener('change', toggle);
window.addEventListener('DOMContentLoaded', toggle);
</script>
@endsection

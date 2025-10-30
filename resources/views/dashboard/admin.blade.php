@extends('layouts.app')

@section('content')
<div class="mb-4">
  <h2 class="fw-bold mb-1"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h2>
  <p class="text-muted">Ringkasan & Analitik Penjualan</p>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
          <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;">Total Produk</div>
          <div class="fs-2 fw-bold" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $totalProducts }}</div>
        </div>
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea20, #764ba220); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
          <i class="bi bi-box-seam" style="font-size: 1.8rem; color: #667eea;"></i>
        </div>
      </div>
      <div class="text-muted" style="font-size: 0.85rem;"><i class="bi bi-graph-up me-1"></i>Inventori aktif</div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
          <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;">Penjualan Hari Ini</div>
          <div class="fs-2 fw-bold" style="background: var(--success-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Rp {{ number_format($todaySales,0,',','.') }}</div>
        </div>
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #11998e20, #38ef7d20); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
          <i class="bi bi-cash-stack" style="font-size: 1.8rem; color: #11998e;"></i>
        </div>
      </div>
      <div class="text-muted" style="font-size: 0.85rem;"><i class="bi bi-calendar-check me-1"></i>Total hari ini</div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
          <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;">Pickup Pending</div>
          <div class="fs-2 fw-bold" style="background: var(--warning-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $pendingPickups }}</div>
        </div>
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb20, #f5576c20); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
          <i class="bi bi-clock-history" style="font-size: 1.8rem; color: #f5576c;"></i>
        </div>
      </div>
      <div class="text-muted" style="font-size: 0.85rem;"><i class="bi bi-hourglass-split me-1"></i>Menunggu pickup</div>
    </div>
  </div>
</div>

<div class="card mb-4 fade-in"><div class="card-body p-4">
  <h5 class="card-title mb-4"><i class="bi bi-graph-up-arrow me-2"></i>Grafik Penjualan 7 Hari Terakhir</h5>
  <canvas id="salesChart" height="100"></canvas>
</div></div>

<div class="card mb-4 fade-in"><div class="card-body p-4">
  <h5 class="card-title mb-4"><i class="bi bi-bell me-2"></i>Notifikasi Pembayaran Terbaru</h5>
  <div class="list-group list-group-flush">
    @forelse($latestOrders as $o)
      <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 12px !important;">
        <div>
          <span class="fw-semibold">#{{ $o->id }}</span>
          <span class="text-muted ms-2">{{ $o->order_type==='pickup_later'?'Ambil Nanti':'Di Toko' }}</span>
          <span class="ms-2 text-muted">Rp {{ number_format($o->grand_total,0,',','.') }}</span>
        </div>
        <span class="badge bg-{{ $o->payment_status==='paid'?'success':'warning' }} text-uppercase">
          <i class="bi bi-{{ $o->payment_status==='paid'?'check-circle':'clock' }} me-1"></i>{{ $o->payment_status }}
        </span>
      </div>
    @empty
      <div class="text-center text-muted py-4">
        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
        <p class="mt-2">Belum ada transaksi</p>
      </div>
    @endforelse
  </div>
</div></div>

<script>
const ctx = document.getElementById('salesChart');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: {!! json_encode($labels) !!},
    datasets: [{
      label: 'Penjualan (Rp)',
      data: {!! json_encode($data) !!},
      fill: true,
      backgroundColor: 'rgba(102, 126, 234, 0.1)',
      borderColor: 'rgb(102, 126, 234)',
      borderWidth: 3,
      tension: 0.4,
      pointBackgroundColor: 'rgb(102, 126, 234)',
      pointBorderColor: '#fff',
      pointBorderWidth: 2,
      pointRadius: 5,
      pointHoverRadius: 7
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: true, position: 'top' },
      tooltip: { 
        backgroundColor: 'rgba(0,0,0,0.8)',
        padding: 12,
        cornerRadius: 8
      }
    },
    scales: {
      y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
      x: { grid: { display: false } }
    }
  }
});
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card fade-in" style="border-radius: 24px; overflow: hidden;">
      <div class="card-body p-5">
        <div class="text-center mb-4">
          <div style="width: 80px; height: 80px; background: var(--success-gradient); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-person-plus text-white" style="font-size: 2rem;"></i>
          </div>
          <h3 class="fw-bold mb-1">Buat Akun Baru</h3>
          <p class="text-muted">Daftar untuk mulai berbelanja</p>
        </div>
        <form method="POST" action="{{ route('register.post') }}">@csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-person me-2"></i>Nama</label>
              <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name') }}" placeholder="Nama lengkap" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-phone me-2"></i>No. HP</label>
              <input type="text" name="phone" class="form-control form-control-lg" value="{{ old('phone') }}" placeholder="08123456789">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-envelope me-2"></i>Email</label>
              <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" placeholder="nama@email.com" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-lock me-2"></i>Password</label>
              <input type="password" name="password" class="form-control form-control-lg" placeholder="Min. 6 karakter" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-lock-fill me-2"></i>Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Ulangi password" required>
            </div>
          </div>
          <div class="mt-4">
            <button class="btn btn-success w-100 py-3 mb-3" style="font-size: 1.1rem;">
              <i class="bi bi-person-check me-2"></i>Daftar Sekarang
            </button>
            <div class="text-center">
              <p class="text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Login di sini</a></p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kasir Pro' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            padding-top: 80px; 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar-brand { 
            font-weight: 700; 
            font-size: 1.5rem;
            background: linear-gradient(90deg, #fff, #a8edea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .navbar {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
        }
        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        .nav-link:hover {
            transform: translateY(-2px);
            color: #a8edea !important;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: #a8edea;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after {
            width: 80%;
        }
        .product-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: white;
        }
        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 12px 35px rgba(0,0,0,0.2);
        }
        .product-card img { 
            max-height: 180px; 
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .product-card:hover img {
            transform: scale(1.1);
        }
        .product-card .card-body {
            background: linear-gradient(180deg, white 0%, #f8f9fa 100%);
        }
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        .btn-success {
            background: var(--success-gradient);
            border: none;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(17, 153, 142, 0.6);
        }
        .btn-warning {
            background: var(--warning-gradient);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
        }
        .card:hover {
            box-shadow: 0 12px 40px rgba(0,0,0,0.18);
        }
        .card-title {
            font-weight: 700;
            color: #2c3e50;
        }
        .alert {
            border: none;
            border-radius: 12px;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .table thead {
            background: var(--primary-gradient);
            color: white;
        }
        .table tbody tr {
            transition: all 0.2s ease;
        }
        .table tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.7rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
        }
        .list-group-item {
            border: none;
            border-radius: 12px !important;
            margin-bottom: 0.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .list-group-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
        .container {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard.redirect') }}">
        <i class="bi bi-shop me-2"></i>Kasir Pro
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample" aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @auth
            @if(auth()->user()->role === 'admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.admin') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}"><i class="bi bi-box-seam me-1"></i>Produk</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}"><i class="bi bi-file-earmark-bar-graph me-1"></i>Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('expenses.index') }}"><i class="bi bi-cash-coin me-1"></i>Pengeluaran</a></li>
            @elseif(auth()->user()->role === 'cashier')
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.cashier') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('orders.catalog') }}"><i class="bi bi-grid me-1"></i>Katalog</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.user') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.catalog') }}"><i class="bi bi-bag me-1"></i>Belanja</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('cart.view') }}"><i class="bi bi-cart3 me-1"></i>Keranjang</a></li>
            @endif
        @endauth
      </ul>
      <ul class="navbar-nav ms-auto">
        @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i>Register</a></li>
        @else
            <li class="nav-item"><span class="navbar-text me-3"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</span></li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf
                    <button class="btn btn-sm btn-outline-light rounded-pill"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                </form>
            </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<main class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{ $slot ?? '' }}
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
</body>
</html>

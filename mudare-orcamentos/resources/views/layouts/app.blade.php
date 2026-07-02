<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Orçamentos Alto Padrão')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        :root { --brand: {{ env('PDF_BRAND_COLOR', '#DD5600') }}; }
        body { background: #f5f5f4; color: #1f2933; }
        .navbar-brand { font-weight: 700; letter-spacing: .5px; }
        .bg-brand { background-color: var(--brand) !important; }
        .text-brand { color: var(--brand) !important; }
        .btn-brand { background-color: var(--brand); border-color: var(--brand); color: #fff; }
        .btn-brand:hover { background-color: #b8470a; border-color: #b8470a; color: #fff; }
        .btn-outline-brand { color: var(--brand); border-color: var(--brand); }
        .btn-outline-brand:hover { background-color: var(--brand); color: #fff; }
        a.text-brand:hover { color: #b8470a !important; }
        .sidebar .nav-link { color: #3a4149; border-radius: .375rem; }
        .sidebar .nav-link.active { background: var(--brand); color: #fff; }
        .sidebar .nav-link:hover:not(.active) { background: #ececec; }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .table thead th { font-size: .8rem; text-transform: uppercase; letter-spacing: .03em; color: #6b7280; }
        footer { font-size: .8rem; color: #6b7280; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-brand shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">◆ ORÇAMENTOS ALTO PADRÃO</a>
        @auth
        <div class="d-flex align-items-center gap-3">
            <span class="text-white-50 small d-none d-md-inline">{{ auth()->user()->name ?? auth()->user()->email }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-light" type="submit">Sair</button>
            </form>
        </div>
        @endauth
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        @auth
        <aside class="col-12 col-md-3 col-lg-2 sidebar py-3">
            <nav class="nav flex-column gap-1">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('works.*') ? 'active' : '' }}" href="{{ route('works.index') }}">Obras</a>
                <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">Clientes</a>
                <a class="nav-link {{ request()->routeIs('architects.*') ? 'active' : '' }}" href="{{ route('architects.index') }}">Arquitetos</a>
                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">Fornecedores</a>
                <a class="nav-link {{ request()->routeIs('prices.*') ? 'active' : '' }}" href="{{ route('prices.index') }}">Preços</a>
                <a class="nav-link {{ request()->routeIs('quote-requests.*') ? 'active' : '' }}" href="{{ route('quote-requests.index') }}">Cotações</a>
            </nav>
            <hr>
            <p class="small text-muted px-2 mb-0">Revisão humana obrigatória. O sistema não substitui responsabilidade técnica.</p>
        </aside>
        @endauth

        <main class="@auth col-12 col-md-9 col-lg-10 @else col-12 @endauth py-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! e(session('success')) !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! e(session('error')) !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Verifique os campos:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <footer class="mt-5 pt-3 border-top text-center">
                <em class="text-brand">O rigor da engenharia para a arte da arquitetura</em>
            </footer>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

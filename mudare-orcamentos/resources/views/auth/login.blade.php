@extends('layouts.app')

@section('title', 'Entrar')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card mt-4">
            <div class="card-body p-4">
                <h1 class="h4 mb-1 text-brand">Acesso ao sistema</h1>
                <p class="text-muted small mb-4">Orçamentos de obras residenciais de alto padrão</p>

                <form method="POST" action="{{ route('login.attempt') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Manter conectado</label>
                    </div>
                    <button type="submit" class="btn btn-brand w-100">Entrar</button>
                </form>

                <p class="small text-muted mt-3 mb-0">
                    Padrão: <code>admin@exemplo.com</code> / <code>password</code>.
                    <strong>Troque a senha imediatamente.</strong>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

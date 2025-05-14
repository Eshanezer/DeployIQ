@extends('layouts.app')

@section('content')
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card mt-8">
                                <div class="card-header pb-0 text-left bg-transparent text-center ">
                                    <div class="w-100 text-center pb-4">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="" class="w-75">
                                    </div>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <label>Email</label>
                                        <div class="mb-3">
                                            <input aria-label="Email" aria-describedby="email-addon" id="email"
                                                type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                                autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input aria-label="Password" aria-describedby="password-addon" id="password"
                                                type="password" class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rememberMe">{{ __('Remember Me') }}</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-success w-100 mt-4 mb-0">Sign
                                                in</button>
                                        </div>
                                        <div class="row mt-3 text-center">
                                            <a href="{{ route('register') }}"><small>No account yet, Please
                                                    register</small></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')
@endsection

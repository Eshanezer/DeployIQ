@extends('layouts.app')

@section('content')
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card mt-8">
                                <div class="card-header pb-0 bg-transparent text-center">
                                    <h3 class="font-weight-bolder text-success text-gradient">Create an account</h3>
                                    <p class="mb-0">Enter your details to create an account</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <label>Name</label>
                                        <div class="mb-3">
                                            <input aria-label="Name" id="name" type="text" class="form-control"
                                                name="name" value="{{ old('name') }}" required autocomplete="email"
                                                autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
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
                                        <label>Retype Password</label>
                                        <div class="mb-3">
                                            <input aria-label="Retype Password" id="password_confirmation" type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" required autocomplete="password_confirmation">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-success w-100 mt-4 mb-0">Create an
                                                account</button>
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

@extends('layouts.front-layout')
@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Login</h1>
                        <form action="{{ route('auth.login') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="mb-2">Email<span class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid
                                @enderror" placeholder="example@example.com" value="{{ old('email') }}">
                                @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Password<span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control @error('password')
                                is-invalid @enderror" placeholder="Enter Password">
                                @error('password')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="mb-2 form-check-label">Remember Me</label>
                            </div>
                            <div class="justify-content-between d-flex">
                                <button type="submit" class="btn btn-primary mt-2">Login</button>
                                <a href="forgot-password.html" class="mt-3">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Do not have an account? <a href="{{ route('registration') }}">Register</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mx-3">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.front-layout')

@section('main')
    <section class="section-dashboard bg-light py-5">
        <div class="container">

            <nav aria-label="breadcrumb" class="p-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.users') }}"><i class="fa fa-arrow-left"
                                aria-hidden="true"></i> &nbsp;Back to Users</a></li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card bg-white">
                        <div class="card-header">
                            <h4>Edit User</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row mb-2">
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group">
                                            <label for="name">Name<small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group">
                                            <label for="email">Email<small class="text-danger">*</small></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile<small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="mobile" name="mobile"
                                                value="{{ $user->mobile }}">
                                            @error('mobile')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-6">
                                        <div class="form-group">
                                            <label for="designation">Designation<small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="designation" name="designation"
                                                value="{{ $user->destination }}">
                                            @error('designation')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
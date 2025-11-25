@extends('layouts.front-layout')

@section('main')
    <section class="section-dashboard bg-light py-5">
        <div class="container">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="p-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>

            <!-- Dashboard Cards -->
            <div class="row g-4 justify-content-center">

                <!-- Users -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center py-4" style="height: 11rem;">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <a href="{{ route('admin.users') }}">
                                <i class="fa-regular fa-user fa-2x"></i>
                                <h5 class="card-title fw-bold mb-2">Users</h5>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Jobs -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center py-4" style="height: 11rem;">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <a href="{{ route('admin.jobs') }}">
                                <i class="fa-solid fa-briefcase fa-2x"></i>
                                <h5 class="card-title fw-bold mb-2">Jobs</h5>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Job Applications -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center py-4" style="height: 11rem;">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <a href="#">
                                <i class="fa-regular fa-file-lines fa-2x"></i>
                                <h5 class="card-title fw-bold mb-2">Job Applications</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.front-layout')

@section('main')
    <section class="section-4 bg-2">
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('profile') }}"><i class="fa fa-arrow-left"
                                        aria-hidden="true"></i> &nbsp;Back to Profile</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8">
                    @include('message')
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h3 class="border-0 fs-5 pb-2 mb-0">My Activity</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date & Time</th>
                                                <th>IP Address</th>
                                                <th>Device</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($user_logins->isNotEmpty())
                                                @foreach ($user_logins as $user_login)
                                                    <tr>
                                                        <td>{{ $user_login->last_login }}</td>
                                                        <td>{{ $user_login->ip_address }}</td>
                                                        <td>{{ $user_login->user_agent ?? 'Unknown' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">No login history available.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
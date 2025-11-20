@extends('layouts.front-layout')

@section('main')
    <section class="section-dashboard bg-light py-5">
        <div class="container">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="p-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
            @include('message')
            <!-- Dashboard Cards -->
            <div class="row g-4 justify-content-center">
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Users</h3>
                            </div>
                            <div style="margin-top: -10px;">
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">designation</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($users->isNotEmpty())
                                        @foreach ($users as $user)
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{ $user->name }}</div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->mobile ?? 'N/A' }}</td>
                                                <td>{{ $user->destination ?? 'N/A' }}</td>
                                                <td id="status">
                                                    {!!  $user->status == 1 ? '<small class="badge bg-success">Active</span>' : '<small class="badge bg-dangrer">Inactive</span>' !!}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3" style="height: 40px;">
                                                        <div class="form-check form-switch mb-0">
                                                            <input class="form-check-input change-status" type="checkbox"
                                                                role="switch" data-id="{{ $user->id }}" {{ $user->status == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                                            class="d-flex align-items-center">
                                                            <i class="fa fa-edit text-warning"
                                                                style="font-size: 1.4rem; line-height: 1;"></i>
                                                        </a>

                                                        <span class="d-flex align-items-center"
                                                            onclick="deleteUser({{ $user->id }})" style="cursor:pointer;">
                                                            <i class="fa fa-trash text-danger"
                                                                style="font-size: 1.4rem; line-height: 1;"></i>
                                                        </span>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>
                        </div>
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJS')
    <script>
        $(document).ready(function () {
            $('.change-status').change(function () {
                let status = $(this).prop('checked') == true ? 1 : 0;
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('user.changeStatus') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == true) {
                            if (response.userStatus == 1) {
                                $('#status').html('<small class="badge bg-success">Active</span>');
                            } else {
                                $('#status').html('<small class="badge bg-danger">Inactive</span>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
        });
        function deleteUser(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: "{{ route('admin.users.delete') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == true) {
                            window.location.href = "{{ route('admin.users') }}";
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
        }
    </script>
@endsection
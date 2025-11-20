@extends('layouts.front-layout')

@section('main')
    <section class="section-dashboard bg-light py-5">
        <div class="container">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="p-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>

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
                                                <td>
                                                    <div class="job-status text-capitalize">
                                                        {{ $user->status == 1 ? 'active' : 'inactive' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input change-status" type="checkbox" 
                                                                role="switch" data-id="{{ $user->id }}" id="status"
                                                                {{ $user->status == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        <a href="#" class="btn btn-outline-warning"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
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
    $(document).ready(function() {
        $('.change-status').change(function() {
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
                        window.location.reload();
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    });
</script>
@endsection
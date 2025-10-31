@extends('layouts.front-layout')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                @include('sidebar')
                <div class="col-lg-9">
                    @include('message')
                    <form action="{{ route('job.store') }}" method="post" name="createJobForm" id="createJobForm">
                        @csrf
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            <option value="">Engineering</option>
                                            <option value="">Accountant</option>
                                            <option value="">Information Technology</option>
                                            <option value="">Fashion designing</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select">
                                            <option>Full Time</option>
                                            <option>Part Time</option>
                                            <option>Remote</option>
                                            <option>Freelance</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            class="form-control">
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="location" id="location" name="location"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5"
                                        placeholder="Benefits"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5"
                                        rows="5" placeholder="Responsibility"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" cols="5"
                                        rows="5" placeholder="Qualifications"></textarea>
                                </div>



                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords<span class="req">*</span></label>
                                    <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                        class="form-control">
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name" name="company_name"
                                            class="form-control">
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location</label>
                                        <input type="text" placeholder="Location" id="company_location"
                                            name="company_location" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" id="company_website" name="company_website"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Save Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                    <form id="profilePicForm" name="profilePicForm" action="" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <p></p>
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

@section('customJS')
    <script>
        $('#userForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $('#userForm').serializeArray();
            // console.log(formData);

            $.ajax({
                url: "{{ route('profile.update') }}",
                type: "PUT",
                dataType: "json",
                data: formData,
                success: function (data) {
                    if (data.status == true) {
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#designation').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        window.location.reload();
                    } else {
                        let errors = data.errors;
                        console.log(errors);
                        if (errors.name) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                        if (errors.email) {
                            $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                        if (errors.designation) {
                            $('#designation').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.designation);
                        } else {
                            $('#designation').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                        if (errors.mobile) {
                            $('#mobile').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.mobile);
                        } else {
                            $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
        $('#profilePicForm').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            console.log(formData);
            $.ajax({
                url: "{{ route('profilePic.update') }}",
                type: "POST",
                dataType: "json",
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    if (data.status == true) {
                        $('#exampleModal').modal('hide');
                        window.location.reload();
                    } else {
                        if (data.errors.image) {
                            $('#image').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(data.errors.image);
                        } else {
                            $('#image').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            })
        });
    </script>
@endsection
@extends('partials.app')

@section('pageTitle', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h6 class="card-title m-0 me-2">Students</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar avatar-md border-5 border-light-primary rounded-circle mx-auto mb-4">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="fa-sharp fa-solid fa-graduation-cap"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-1 me-2">{{ $student_count }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h6 class="card-title m-0 me-2">Staffs</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar avatar-md border-5 border-light-primary rounded-circle mx-auto mb-4">
                            <span class="avatar-initial rounded-circle bg-label-secondary">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-1 me-2">{{ $staff_count }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h6 class="card-title m-0 me-2">Administrators</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar avatar-md border-5 border-light-success rounded-circle mx-auto mb-4">
                            <span class="avatar-initial rounded-circle bg-label-success"><i
                                    class="bx bx-user bx-sm"></i></span>
                        </div>
                        <h3 class="card-title mb-1 me-2">{{ $users_count }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h6 class="card-title m-0 me-2">RFIDs</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar avatar-md border-5 border-light-warning rounded-circle mx-auto mb-4">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="fa-solid fa-address-card"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-1 me-2">{{ $uuid_count }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">Activity Logs</h5>
            <div class="card-datatable table-responsive">
                <table class="table border-top" id="example1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>UUID</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->full_name }}</td>
                                <td>{{ $log->uuid }}</td>
                                <td>{{ $log->message }}</td>
                                <td>{{ $log->time_in }}</td>
                                <td>{{ $log->time_out }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

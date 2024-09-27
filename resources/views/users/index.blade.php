@extends('partials.app')

@section('pageTitle', 'Users')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between py-3 mb-4">
                <div>
                    <h4 class="m-0">
                        <span class="text-muted fw-light" style="font-size: 18px;">Settings /</span>
                        <span class="text-primary" style="font-size: 18px; font-weight: bold;">User</span>
                    </h4>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <button class="btn btn-primary d-flex align-items-center justify-content-center" type="button"
                        data-bs-toggle="modal" data-bs-target="#user" style="height: 40px; width: 100%; font-size: 14px;">
                        <i class="bx bx-plus-medical" style="font-size: 18px; margin-right:20px;"></i>
                        <span class="d-sm-none d-none d-lg-inline">Add User</span>
                    </button>
                </div>
            </div>
        </div>

        @if ($errors->any() || session('success'))
            <div class="col-12">
                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Success Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        @endif

        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top" id="example1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td class="d-flex justify-content-start align-items-start">
                                    <a href="{{ route('edit.user', $user->id) }}" class="me-2 text-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ route('destroy.user', $user->id) }}" class="text-danger"
                                        onclick="deleteUser({{ $user->id }})" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- GET STARTED MODAL TO EITHER SELECT THE SMS OR USSD SURVEY --}}
    <div class="modal fade" id="user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="address-title">Add new User</h3>
                        <p class="address-subtitle">
                            Type in the new user data and click proceed to add to database
                        </p>
                    </div>
                    <form id="addNewAddressForm" class="row g-3" method="POST" action="{{ route('save.user') }}">
                        @csrf
                        <div class="col-12">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Enter your email here" />
                                </div>
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="name"
                                        value="{{ old('name') }}" placeholder="Enter your full name here" />
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        value="{{ old('password') }}" placeholder="Enter your password here" />
                                </div>

                                <!-- Role Selection -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">User Role</label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role"
                                        name="role" aria-describedby="roleHelp">
                                        <option value="" disabled selected>Select user role</option>
                                        <option value="super-admin" {{ old('role') == 'super-admin' ? 'selected' : '' }}>
                                            Super Admin</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                    </select>
                                    @error('role')
                                        <div id="roleHelp" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                Proceed
                            </button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Danger Header Modal -->
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" id="deleteUser">
                @csrf
                @method('DELETE')

                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title" id="danger-header-modalLabel">Confirm Delete</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-hidden="true"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-bold">
                            Are you sure you want to delete this record ?
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

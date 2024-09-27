@extends('partials.app')

@section('pageTitle', 'Edit User')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12">
                <!-- Edit student Information -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit User</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update.user', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Full Name -->
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="full-name" name="name" placeholder="Full Name"
                                    value="{{ old('name', $user->name) }}">
                                <label for="full-name">Full Name</label>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email Address"
                                    value="{{ old('email', $user->email) }}">
                                <label for="email">Email</label>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Role Dropdown -->
                            <div class="form-floating form-floating-outline mb-5">
                                <select class="form-control @error('role') is-invalid @enderror" id="role"
                                    name="role">
                                    <option value="">Select Role</option>

                                    <!-- Check if the current role is super-admin or admin -->
                                    <option value="super-admin"
                                        {{ old('role', $user->role) == 'super-admin' ? 'selected' : '' }}>Super Admin
                                    </option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                </select>
                                <label for="role">Role</label>

                                <!-- Error Message for role -->
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <button type="submit" class="btn btn-primary mt-3">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('partials.app')

@section('pageTitle', 'Edit Staff')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12">
                <!-- Edit Staff Information -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Staff</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update.staff', $staff->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Full Name -->
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full-name" name="full_name" placeholder="Full Name"
                                    value="{{ old('full_name', $staff->full_name) }}">
                                <label for="full-name">Full Name</label>
                                @error('full_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email Address"
                                    value="{{ old('email', $staff->email) }}">
                                <label for="email">Email</label>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- UUID Dropdown -->
                            <div class="form-floating form-floating-outline mb-5">
                                <select class="form-control @error('uuid') is-invalid @enderror" id="uuid"
                                    name="uuid">
                                    <option value="">Select UUID</option>
                                    @foreach ($codes as $code)
                                        <option value="{{ $code->uuid }}"
                                            {{ old('uuid', $staff->uuid) == $code->uuid ? 'selected' : '' }}>
                                            {{ $code->uuid }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="uuid">UUID</label>
                                @error('uuid')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- MSISDN -->
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control @error('msisdn') is-invalid @enderror"
                                    id="msisdn" name="msisdn" placeholder="MSISDN"
                                    value="{{ old('msisdn', $staff->msisdn) }}">
                                <label for="msisdn">MSISDN</label>
                                @error('msisdn')
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

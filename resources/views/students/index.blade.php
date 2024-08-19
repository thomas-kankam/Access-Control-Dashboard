@extends('partials.app')

@section('pageTitle', 'Students')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between py-3 mb-4">
                <div>
                    <h4 class="m-0">
                        <span class="text-muted fw-light" style="font-size: 18px;">Settings /</span>
                        <span class="text-primary" style="font-size: 18px; font-weight: bold;">Student</span>
                    </h4>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <button class="btn btn-primary d-flex align-items-center justify-content-center" type="button"
                        data-bs-toggle="modal" data-bs-target="#rfid" style="height: 40px; width: 100%; font-size: 14px;">
                        <i class="bx bx-plus-medical" style="font-size: 18px; margin-right:20px;"></i>
                        <span class="d-sm-none d-none d-lg-inline">Assign UUID To Student</span>
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
                            <th>Email</th>
                            <th>Msisdn</th>
                            <th>Index No</th>
                            <th>UUID</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->msisdn }}</td>
                                <td>{{ $student->index_no }}</td>
                                <td>{{ $student->uuid }}</td>
                                <td>{{ $student->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- GET STARTED MODAL TO EITHER SELECT THE SMS OR USSD SURVEY --}}
    <div class="modal fade" id="rfid" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="address-title">Assign RFID to student</h3>

                    </div>
                    <form id="addNewAddressForm" class="row g-3" method="POST" action="{{ route('save.student') }}">
                        @csrf
                        <div class="col-12">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="rfid" class="form-label">Unassigned Students</label>
                                    <select class="form-control @error('code_id') is-invalid @enderror" id="rfid"
                                        name="full_name" aria-describedby="rfidHelp">
                                        <option value="" disabled selected>Select student</option>
                                        @foreach ($unassigned as $unassign)
                                            <option value="{{ $unassign->full_name }}">
                                                {{ $unassign->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('full_name')
                                        <div id="rfidHelp" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="rfid" class="form-label">Available RFIDs</label>
                                    <select class="form-control @error('code_id') is-invalid @enderror" id="rfid"
                                        name="uuid" aria-describedby="rfidHelp">
                                        <option value="" disabled selected>Select RFID and assign to staff</option>
                                        @foreach ($codes as $code)
                                            <option value="{{ $code->uuid }}"
                                                {{ old('uuid') == $code->uuid ? 'selected' : '' }}>
                                                {{ $code->uuid }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('uuid')
                                        <div id="rfidHelp" class="invalid-feedback">
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
@endsection

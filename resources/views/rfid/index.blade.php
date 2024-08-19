@extends('partials.app')

@section('pageTitle', 'RFID')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between py-3 mb-4">
                <div>
                    <h4 class="m-0">
                        <span class="text-muted fw-light" style="font-size: 18px;">Settings /</span>
                        <span class="text-primary" style="font-size: 18px; font-weight: bold;">RFID</span>
                    </h4>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <button class="btn btn-primary d-flex align-items-center justify-content-center" type="button"
                        data-bs-toggle="modal" data-bs-target="#rfid" style="height: 40px; width: 100%; font-size: 14px;">
                        <i class="bx bx-plus-medical" style="font-size: 18px; margin-right:20px;"></i>
                        <span class="d-sm-none d-none d-lg-inline">Add RFID</span>
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
                            <th>UUID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rfids as $rfid)
                            <tr>
                                <td>{{ $rfid->uuid }}</td>
                                <td>
                                    @if ($rfid->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $rfid->created_at }}</td>
                                <td>
                                    <!-- Button to trigger the modal -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editRfid{{ $rfid->id }}"
                                        @if ($rfid->status == 'active') disabled @endif>
                                        Edit
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editRfid{{ $rfid->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-simple modal-edit-address">
                                    <div class="modal-content p-3 p-md-5">
                                        <div class="modal-body">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <div class="text-center mb-4">
                                                <h3 class="address-title">Edit RFID</h3>
                                                <p class="address-subtitle">
                                                    Update the RFID code and click proceed to save changes
                                                </p>
                                            </div>
                                            <form id="editAddressForm{{ $rfid->id }}" class="row g-3" method="POST"
                                                action="{{ route('settings.update', $rfid->id) }}">
                                                @csrf
                                                @method('PUT') <!-- Specify the method as PUT -->
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="mb-3">
                                                            <label for="uuid" class="form-label">UUID</label>
                                                            <input type="text" class="form-control" id="uuid"
                                                                name="uuid" value="{{ $rfid->uuid }}"
                                                                placeholder="Enter your uuid here" />
                                                        </div>

                                                        <div class="col-12 text-center">
                                                            <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                                                Proceed
                                                            </button>
                                                            <button type="reset" class="btn btn-label-secondary"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <h3 class="address-title">Add new RFID</h3>
                        <p class="address-subtitle">
                            Type the new RFID code and click proceed to add to database
                        </p>
                    </div>
                    <form id="addNewAddressForm" class="row g-3" method="POST" action="{{ route('settings.store') }}">
                        @csrf
                        <div class="col-12">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="email" class="form-label">UUID</label>
                                    <input type="text" class="form-control" id="uuid" name="uuid"
                                        value="{{ old('uuid') }}" placeholder="Enter your uuid here" />
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

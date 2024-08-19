@extends('partials.app')

@section('pageTitle', 'Logs')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
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

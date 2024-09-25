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
                            <th>User Type</th>
                            <th>UUID</th>
                            <th>State</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->full_name }}</td>
                                <td>{{ $log->user_type }}</td>
                                <td>{{ $log->uuid }}</td>
                                <td>{{ $log->state }}</td>
                                <td>{{ $log->time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

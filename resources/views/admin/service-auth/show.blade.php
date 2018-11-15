<?php /**@var \App\Models\Channels\Channel $channel */ ?>

@extends('layouts.admin')


@section('content')
    <a href="{{ route('service.index') }}" class="btn btn-success">List</a>

    <table class="table table-bordered table stripped">
        <tbody>
        <tr>
            <th>ID</th>
            <td>{{ $service->service_id }}</td>
        </tr>
        <tr>
            <th>Access token</th>
            <td>{{ $service->access_token }}</td>
        </tr>
        </tbody>
    </table>

@endsection
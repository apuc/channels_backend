<?php /**@var \App\Models\Channels\IntegrationType $type */ ?>

@extends('layouts.admin')

@section('content')

    <a href="{{ route('integration-types.index') }}" class="btn btn-success">List</a>

    <table class="table table-bordered table stripped">
        <tbody>
        <tr>
            <th>ID</th>
            <td>{{ $type->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $type->title }}</td>
        </tr>
        <tr>
            <th>Slug</th>
            <td>{{ $type->slug }}</td>
        </tr>
        <tr>
            <th>Fields</th>
            <td>{{ $type->fields }}</td>
        </tr>
        <tr>
            <th>Options</th>
            <td>{{ $type->options }}</td>
        </tr>
        </tbody>
    </table>

@endsection

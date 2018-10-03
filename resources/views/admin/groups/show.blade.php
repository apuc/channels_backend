<?php /**@var \App\Models\Channels\Group $group */ ?>

@extends('layouts.admin')

@section('title', __('Group') . ': ' . $group->title )

@section('content')

    <table class="table table-bordered table stripped">
        <tbody>
        <tr>
            <th>ID</th>
            <td>{{ $group->channels_group_id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $group->title }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $group->slug }}</td>
        </tr>

        <tr>
            <th>Users</th>
            <td>{{ $group->users()->pluck('email')->implode(', ') }}</td>
        </tr>
        </tbody>
    </table>

@endsection
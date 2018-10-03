<?php /**@var \App\Models\Channels\Channel $channel */ ?>

@extends('layouts.admin')


@section('content')
    <a href="{{ route('channel.index') }}" class="btn btn-success">List</a>

    <table class="table table-bordered table stripped">
        <tbody>
        <tr>
            <th>ID</th>
            <td>{{ $channel->channels_group_id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $channel->title }}</td>
        </tr>
        <tr>
            <th>Slug</th>
            <td>{{ $channel->slug }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ $channel->type }}</td>
        </tr>
        </tbody>
    </table>

@endsection
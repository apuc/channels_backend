<?php /**@var \App\Models\Channels\Group[] $groups*/?>

@extends('layouts.app')

@section('content')

    <a href="{{ route('group.create') }}" class="btn btn-success">Create group</a>
    
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">title</th>
                <th scope="col">slug</th>
                <th scope="col">status</th>
            </tr>
            </thead>
            <tbody>

            @foreach($groups as $group)
                <tr>
                    <th scope="row">{{ $group->channels_group_id }}</th>
                    <td><a href="{{ route('group.show', $group) }}">{{ $group->title }}</a></td>
                    <td>{{ $group->slug }}</td>
                    <td>{{ $group->status }}</td>
                </tr>
            @endforeach


            </tbody>
        </table>

        {{ $groups->links() }}
    </div>


@endsection
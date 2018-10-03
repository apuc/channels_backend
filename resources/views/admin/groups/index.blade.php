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
                <th scope="col">is_deleted</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($groups as $group)
                <tr>
                    <th scope="row">{{ $group->channels_group_id }}</th>
                    <td><a href="{{ route('group.show', $group) }}">{{ $group->title }}</a></td>
                    <td>{{ $group->slug }}</td>
                    <td>{{ $group->status }}</td>
                    <td>
                        @if($group->deleted_at === null)
                            No
                        @else
                            Yes
                        @endif
                    </td>
                    <td>
                        @if ($group->deleted_at === null)

                        <form action="{{ route('group.destroy', $group) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        @endif

                        <a href="{{ route('group.edit', $group) }}" class="btn btn-info">Edit</a>
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>

        {{ $groups->links() }}
    </div>


@endsection
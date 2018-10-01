<?php /**@var \App\Models\Channels\Channel[] $channels*/?>

@extends('layouts.app')

@section('content')

    <a href="{{ route('group.create') }}" class="btn btn-success">Create channel</a>
    
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

            @foreach($channels as $channel)
                <tr>
                    <th scope="row">{{ $channel->channel_id }}</th>
                    <td><a href="{{ route('channel.show', $channel) }}">{{ $channel->title }}</a></td>
                    <td>{{ $channel->slug }}</td>
                    <td>{{ $channel->status }}</td>
                    <td>
                        @if($channel->deleted_at === null)
                            No
                        @else
                            Yes
                        @endif
                    </td>
                    <td>
                        @if ($channel->deleted_at === null)

                        <form action="{{ route('group.destroy', $channel) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        @endif

                        <a href="{{ route('group.edit', $channel) }}" class="btn btn-info">Edit</a>
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>

        {{ $channels->links() }}
    </div>


@endsection
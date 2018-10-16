<?php /**@var \App\Models\Channels\Channel[] $channels*/?>

@extends('layouts.admin')

@section('title', trans('general.channels'))
@section('h1', trans('general.channels'))
@section('content')
    <div class="row ml-3 mr-3">
    <a href="{{ route('channel.create') }}" class="btn btn-success mt-2 mb-2">@lang('general.create_channel')</a>
    

        <table class="table">
            <thead>
            <tr>
                <th scope="col">@lang('ID')</th>
                <th scope="col">@lang('general.title')</th>
                <th scope="col">@lang('general.slug')</th>
                <th scope="col">@lang('general.status')</th>
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

                        <form action="{{ route('channel.destroy', $channel) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">@lang('general.delete')</button>
                        </form>

                        @endif

                        {{--<a href="{{ route('group.edit', $channel) }}" class="btn btn-info">@lang('general.edit')</a>--}}
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>


    </div>
    <div class="row justify-content-center">
        {{ $channels->links() }}
    </div>

@endsection
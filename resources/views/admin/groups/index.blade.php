<?php /**@var \App\Models\Channels\Group[] $groups*/?>

@extends('layouts.admin')

@section('title', trans('general.groups'))
@section('h1', trans('general.groups'))

@section('content')
    <div class="row mr-3 ml-3">
    <a href="{{ route('group.create') }}" class="btn btn-success mt-2 mb-2">@lang('general.create_group')</a>
    

        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">@lang('general.title')</th>
                <th scope="col">@lang('general.slug')</th>
                <th scope="col">@lang('general.status')</th>
                <th scope="col">@lang('general.deleted')</th>
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

                            <button type="submit" class="btn btn-danger">@lang('general.delete')</button>
                        </form>

                        @endif

                        <a href="{{ route('group.edit', $group) }}" class="btn btn-info">@lang('general.edit')</a>
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>

    <div class="row justify-content-center">
        {{ $groups->links() }}
    </div>


@endsection
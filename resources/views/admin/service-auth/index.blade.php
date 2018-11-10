<?php /**@var \App\Extensions\Models\ServiceAuth[] $services*/?>

@extends('layouts.admin')

@section('title', trans('general.services'))
@section('h1', trans('general.services'))
@section('content')
    <div class="row ml-3 mr-3">
    <a href="{{ route('service.create') }}" class="btn btn-success mt-2 mb-2">@lang('general.create_service')</a>
    

        <table class="table">
            <thead>
            <tr>
                <th scope="col">@lang('ID')</th>
                <th scope="col">@lang('general.access_token')</th>
                <th scope="col">@lang('general.status')</th>
                <th scope="col">actions</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($services as $service)
                <tr>
                    <td>{{ $service->service_id }}</td>
                    <td>{{ $service->access_token }}</td>
                    <td>{{ $service->status }}</td>
                    <td>
                        <form action="{{ route('service.destroy', $service) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">@lang('general.delete')</button>
                        </form>

                        {{--<a href="{{ route('group.edit', $channel) }}" class="btn btn-info">@lang('general.edit')</a>--}}
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>


    </div>
    <div class="row justify-content-center">
        {{ $services->links() }}
    </div>

@endsection
<?php /** @var \App\Models\Channels\IntegrationType[] $types */ ?>
@extends('layouts.admin')

@section('title', trans('general.integration_types'))
@section('h1', trans('general.integration_types'))

@section('content')

    <div class="row ml-3 mr-3">
        <a href="{{ route('integration-types.create') }}" class="btn btn-success mt-2 mb-2">@lang('general.create_type_integration')</a>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">@lang('ID')</th>
            <th scope="col">@lang('general.title')</th>
            <th scope="col">@lang('general.slug')</th>
            <th scope="col">@lang('general.fields')</th>
            <th scope="col">@lang('general.options')</th>
            <th scope="col">@lang('general.delete')</th>
            <th scope="col">@lang('general.edit')</th>
        </tr>
        </thead>
        <tbody>

        @foreach($types as $type)
            <tr>
                <th scope="row">{{ $type->id }}</th>
                <td><a href="{{ route('integration-types.show', $type) }}">{{ $type->title }}</a></td>
                <td>{{ $type->slug }}</td>
                <td>{{ $type->fields }}</td>
                <td>{{ $type->options }}</td>
                <td>
                    <form action="{{ route('integration-types.destroy', $type) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">@lang('general.delete')</button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('integration-types.edit', $type) }}" class="btn btn-info">@lang('general.edit')</a>
                </td>
            </tr>
        @endforeach


        </tbody>
    </table>
@endsection

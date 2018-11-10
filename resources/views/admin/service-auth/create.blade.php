@extends('layouts.admin')


@section('title', __('general.create_service'))

@section('content')

    <form action="{{ route('service.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="title">@lang('ID')</label>
            <input type="text" name="id" class="form-control" id="id" placeholder="@lang('general.enter') @lang('general.service') @lang('id')" value="{{ old('id', '') }}">
            @if($errors->has('id'))
                <span class="invalid-feedback"><strong>{{ $errors->first('id') }}</strong></span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">@lang('general.save')</button>
    </form>

@endsection
@extends('layouts.admin')

@section('title', __('general.create_type_integration'))
@section('h1', __('general.create_type_integration'))

@section('content')

    <form action="{{ route('integration-types.store') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="title">@lang('general.title')</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="@lang('general.enter') @lang('general.title')" value="{{ old('title', '') }}">
            @if($errors->has('title'))
                <span class="invalid-feedback"><string>{{ $errors->first('title') }}</string></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug">@lang('general.slug')</label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="@lang('general.enter') @lang('general.slug')" value="{{ old('slug', '') }}">
            @if($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="user_can_create">@lang('general.user_can_create')</label>
            <input type="checkbox" name="user_can_create"  id="user_can_create"  value="{{ old('user_can_create', '') }}">
            @if($errors->has('user_can_create'))
                <span class="invalid-feedback"><string>{{ $errors->first('user_can_create') }}</string></span>
            @endif
        </div>

        <div class="form-group">
            <label for="is_rss">RSS интеграция</label>
            <input type="checkbox" name="is_rss"  id="is_rss"  value="1">
            @if($errors->has('is_rss'))
                <span class="invalid-feedback"><string>{{ $errors->first('is_rss') }}</string></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug">RSS Url (Только для rss интеграций)</label>
            <input type="text" name="rss_url" class="form-control" id="rss_url" placeholder="Url для парсинга rss" value="{{ old('rss_url', '') }}">
            @if($errors->has('rss_url'))
                <span class="invalid-feedback"><strong>{{ $errors->first('rss_url') }}</strong></span>
            @endif
        </div>

        <fields-editor title="Поля для создания" input-name="fields"></fields-editor>
        @if($errors->has('fields'))
            <span class="invalid-feedback"><string>{{ $errors->first('fields') }}</string></span>
        @endif

        <fields-editor title="Поля для добавления в канал" input-name="options"></fields-editor>
        @if($errors->has('options'))
            <span class="invalid-feedback"><string>{{ $errors->first('options') }}</string></span>
        @endif

        <button type="submit" class="btn btn-primary mb-3">@lang('general.save')</button>
    </form>

@endsection

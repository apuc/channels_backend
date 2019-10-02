<?php /** IntegrationType $type */ ?>
@extends('layouts.admin')

@section('title', __('general.edit'))
@section('h1', __('general.edit'))

@section('content')

    <form action="{{ route('integration-types.update', $type) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">@lang('general.title')</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="@lang('general.enter') @lang('general.title')" value="{{$type->title}}">
            @if($errors->has('title'))
                <span class="invalid-feedback"><string>{{ $errors->first('title') }}</string></span>
            @endif
        </div>
        <div class="form-group">
            <label for="slug">@lang('general.slug')</label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="@lang('general.enter') @lang('general.slug')" value="{{ $type->slug }}">
            @if($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>
        <div class="form-group">
            <label for="fields">@lang('general.fields')</label>
            <textarea name="fields" class="form-control" id="fields" cols="30" rows="5">{{ $type->fields }}</textarea>
            @if($errors->has('fields'))
                <span class="invalid-feedback"><strong>{{ $errors->first('fields') }}</strong></span>
            @endif
        </div>
        <div class="form-group">
            <label for="options">@lang('general.options')</label>
            <textarea name="options" class="form-control" id="options" cols="30" rows="5">{{ $type->options }}</textarea>
            @if($errors->has('options'))
                <span class="invalid-feedback"><strong>{{ $errors->first('options') }}</strong></span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">@lang('general.save')</button>
    </form>

@endsection

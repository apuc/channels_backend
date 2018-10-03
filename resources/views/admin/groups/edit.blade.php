<?php
/**
 * @var Group $group
 */

use App\Models\Channels\Group;
?>

@extends('layouts.admin')


@section('content')

    <form action="{{ route('group.update', $group) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title"
            value="{{ old('title', $group->title) }}">
            @if($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="Slug" value="{{ old('slug', $group->slug) }}">
            @if($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option></option>
                <option {{(old('status', $group->status) === \App\Models\Channels\Group::STATUS_ACTIVE) ? 'selected' : '' }}
                        value="{{ \App\Models\Channels\Group::STATUS_ACTIVE }}">Active</option>
                <option {{(old('status', $group->status) === \App\Models\Channels\Group::STATUS_DISABLE) ? 'selected' : '' }}
                        value="{{ \App\Models\Channels\Group::STATUS_DISABLE }}">Disable</option>
            </select>

            @if($errors->has('status'))
                <span class="invalid-feedback active"><strong>{{ $errors->first('status') }}</strong></span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
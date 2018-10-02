@extends('layouts.app')


@section('content')

    <form action="{{ route('channel.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="{{ old('title', '') }}">
            @if($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="Slug" value="{{ old('slug', '') }}">
            @if($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>


        <div class="form-group">
            <label for="users">Users</label>
            <input type="hidden" name="user_ids[]" class="form-control" id="user_ids" placeholder="User" value="{{ Auth::id() }}">

            <select name="user_ids[]" id="users" multiple>
                <option></option>
                @foreach(\App\User::where('user_id', '<>', Auth::id())->get() as $user)

                    <option value="{{ $user->user_id }}">{{ $user->email }}</option>

                @endforeach
            </select>

            @if($errors->has('user_ids') || $errors->has('user_ids.*'))
                <span class="invalid-feedback"><strong>{{ $errors->first('user_ids') }}</strong></span>
                <span class="invalid-feedback"><strong>{{ $errors->first('user_ids.*') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="status">Type</label>
            <select class="form-control" id="type" name="type">
                <option></option>
                <option value="{{ \App\Models\Channels\Channel::TYPE_CHAT }}">Chat</option>
                <option value="{{ \App\Models\Channels\Channel::TYPE_WALL}}">Wall</option>
            </select>

            @if($errors->has('type'))
                <span class="invalid-feedback active"><strong>{{ $errors->first('type') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="status">Private</label>
            <select class="form-control" id="private" name="private">
                <option></option>
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>

            @if($errors->has('private'))
                <span class="invalid-feedback active"><strong>{{ $errors->first('private') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option></option>
                <option value="{{ \App\Models\Channels\Channel::STATUS_ACTIVE }}">Active</option>
                <option value="{{ \App\Models\Channels\Channel::STATUS_DISABLE }}">Disable</option>
            </select>

            @if($errors->has('status'))
                <span class="invalid-feedback active"><strong>{{ $errors->first('status') }}</strong></span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
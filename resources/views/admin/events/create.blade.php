@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.event.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("events.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Input Nama Event -->
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.event.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($event) ? $event->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.event.fields.name_helper') }}
                </p>
            </div>

            <!-- Input Waktu Mulai -->
            <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                <label for="start_time">{{ trans('cruds.event.fields.start_time') }}*</label>
                <input type="text" id="start_time" name="start_time" class="form-control datetime" value="{{ old('start_time', isset($event) ? $event->start_time : '') }}" required>
                @if($errors->has('start_time'))
                    <em class="invalid-feedback">
                        {{ $errors->first('start_time') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.event.fields.start_time_helper') }}
                </p>
            </div>

            <!-- Input Waktu Selesai -->
            <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                <label for="end_time">{{ trans('cruds.event.fields.end_time') }}*</label>
                <input type="text" id="end_time" name="end_time" class="form-control datetime" value="{{ old('end_time', isset($event) ? $event->end_time : '') }}" required>
                @if($errors->has('end_time'))
                    <em class="invalid-feedback">
                        {{ $errors->first('end_time') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.event.fields.end_time_helper') }}
                </p>
            </div>

            <!-- Input Lokasi -->
            <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                <label for="location">{{ trans('cruds.event.fields.location') }}*</label> <!-- Updated key for "Lokasi" -->
                <input type="text" id="location" name="location" class="form-control" value="{{ old('location', isset($event) ? $event->location : '') }}" required>
                @if($errors->has('location'))
                    <em class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.event.fields.location_helper') }}
                </p>
            </div>

            <!-- Input Foto -->
            <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                <label for="photo">{{ trans('cruds.event.fields.photo') }}</label>
                <input type="file" id="photo" name="photo" class="form-control">
                @if($errors->has('photo'))
                    <em class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </em>
                @endif
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection

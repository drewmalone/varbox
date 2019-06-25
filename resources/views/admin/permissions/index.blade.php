@extends('varbox::layouts.admin.default')

@section('title', $title)

@section('content')
    <div class="row row-cards">
        <div class="col-lg-3">
            {!! button()->addRecord(route('admin.permissions.create')) !!}

            @include('varbox::admin.auth.permissions._filter')
        </div>
        <div class="col-lg-9">
            @include('varbox::admin.auth.permissions._table')

            {!! pagination('admin')->render($items) !!}
        </div>
    </div>
@endsection

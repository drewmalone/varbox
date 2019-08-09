@extends('varbox::layouts.admin.default')

@section('title', $title)

@section('content')
    <div class="row row-cards">
        <div class="col-lg-3">
            @permission('cities-add')
                {!! button()->addRecord(route('admin.cities.create')) !!}
            @endpermission

            @include('varbox::admin.cities._filter')
        </div>
        <div class="col-lg-9">
            @include('varbox::admin.cities._table')

            {!! $items->links('varbox::pagination.default', request()->query()) !!}
        </div>
    </div>
@endsection

{!! validation('admin')->errors() !!}

@if($item->exists)
    {!! form_admin()->model($item, ['url' => $url, 'method' => 'put', 'class' => 'frm row row-cards', 'files' => true]) !!}
@else
    {!! form_admin()->open(['url' => $url, 'method' => 'post', 'class' => 'frm row row-cards', 'files' => true]) !!}
@endif
<div class="col-md-12">
    <div class="card">
        <div class="card-status bg-blue"></div>
        <div class="card-header">
            <h3 class="card-title">Basic Info</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {!! form_admin()->text('name', 'Name', null, ['required']) !!}
                </div>
                <div class="col-md-6">
                    {!! form_admin()->select('type', 'Type', ['' => 'Please select'] + $types, null, ['required']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-status bg-green"></div>
        <div class="card-header">
            <h3 class="card-title">Content Info</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {!! form_admin()->text('data[subject]', 'Subject') !!}
                </div>
                <div class="col-md-6">
                    {!! uploader()->field('data[attachment]')->label('Attachment')->model($item)->manager() !!}
                </div>
                <div class="col-md-12">
                    {!! form_admin()->editor('data[message]', 'Message') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-status bg-red"></div>
        <div class="card-header">
            <h3 class="card-title">Sender Info</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    {!! form_admin()->text('data[from_name]', 'From Name', $item && $item->exists ? $item->data['from_name'] : null, ['placeholder' => 'default is ' . $fromName]) !!}
                </div>
                <div class="col-md-4">
                    {!! form_admin()->text('data[from_email]', 'From Email', $item && $item->exists ? $item->data['from_email'] : null, ['placeholder' => 'default is ' . $fromEmail]) !!}
                </div>
                <div class="col-md-4">
                    {!! form_admin()->text('data[reply_to]', 'Reply To', $item && $item->exists ? $item->data['reply_to'] : null, ['placeholder' => 'default is ' . $fromEmail]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex text-left">
                {!! button()->cancelAction(route('admin.emails.index')) !!}
                @if($item->exists)
                    {!! button()->saveAndStay() !!}
                @else
                    {!! button()->saveAndNew() !!}
                    {!! button()->saveAndContinue('admin.emails.edit') !!}
                @endif
                {!! button()->saveRecord() !!}
            </div>
        </div>
    </div>
</div>
{!! form_admin()->close() !!}

@push('scripts')
    {!! JsValidator::formRequest(config('varbox.bindings.form_requests.email_form_request', \Varbox\Requests\EmailRequest::class), '.frm') !!}
@endpush
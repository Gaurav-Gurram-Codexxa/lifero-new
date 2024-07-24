@extends('layouts.app')
@section('title')
{{__('messages.lead.edit_lead')}}
@endsection
@section('page_css')
{{-- <link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">--}}
@endsection
@section('header_toolbar')
<div class="container-fluid">
    <div class="d-md-flex align-items-center justify-content-between mb-7">
        <h1 class="mb-0">@yield('title')</h1>
        <a href="{{ route('leads.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                {{ Form::model($lead, ['route' => ['leads.update', $lead->id], 'method' => 'patch', 'files' => 'true', 'id' => 'editLeadForm']) }}

                @include('leads.edit_fields')

                {{ Form::close() }}
                {{ Form::hidden('utilsScript', asset('assets/js/int-tel/js/utils.min.js'), ['class' => 'utilsScript']) }}
                {{ Form::hidden('isEdit', true, ['class' => 'isEdit']) }}
                {{ Form::hidden('defaultLeadEditAvatarImageURL', asset('assets/img/avatar.png'), ['id' => 'defaultLeadEditAvatarImageURL']) }}
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Remark by</th>
                            <th>Created at</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lead->remarks ?? [] as $remark)
                        <tr>
                            <td>{{$remark['remark_by']}}</td>
                            <td>{{ \Carbon\Carbon::parse($remark['created_at'])->format('d M y H:i:s')}}</td>
                            <td>{!! $remark['remark'] !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
{{--let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";--}}
{{--let isEdit = true;--}}
{{--let defaultAvatarImageUrl = "{{ asset('assets/img/avatar.png') }}";--}}
{{-- <script src="{{ mix('assets/js/leads/create-edit.js') }}"></script>--}}
{{-- <script src="{{ mix('assets/js/custom/add-edit-profile-picture.js') }}"></script>--}}
{{-- <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>--}}
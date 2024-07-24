<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('Name',__('messages.user.name').(':'), ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::text('name', null, ['class' => 'form-control','required']) }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('Rate',__('messages.rate').(':'), ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::text('rate', null, ['class' => 'form-control','required']) }}
        </div>
    </div>

    <div class="d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2']) }}
        <a href="{{ route('super.admin.tax.index') }}"
        class="btn btn-secondary">{{__('messages.common.cancel')}}</a>
    </div>
</div>

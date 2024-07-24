<div class="row">
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-5 text-gray-600">Patient:</label>
        <span class="fs-5 text-gray-800">{{$case_session->case->patient->user->full_name}} ({{$case_session->case->patient->unique_id}})</span>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-5 text-gray-600">Case id:</label>
        <span class="fs-5 text-gray-800">{{$case_session->case->case_id . ' - ' . $case_session->no}}</span>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-5 text-gray-600">Doctor:</label>
        <span class="fs-5 text-gray-800">{{$case_session->case->doctor->user->full_name}}</span>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-5 text-gray-600">Case Handler:</label>
        <span class="fs-5 text-gray-800">{{$case_session->case->case_handler->user->full_name}}</span>
    </div>
    <div class="col-sm-12 d-flex flex-column mb-md-10 mb-5">
        <label for="name" class="pb-2 fs-5 text-gray-600">Services:</label>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th class="form-label fw-bolder text-gray-700 mb-3">Service</th>
                    <th class="form-label fw-bolder text-gray-700 mb-3">Quantity</th>
                    <th class="form-label fw-bolder text-gray-700 mb-3">Rate</th>
                    <th class="form-label fw-bolder text-gray-700 mb-3">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($case_session->services as $s)
                <tr>
                    <td>{{$services[$s['service_id']]}}</td>
                    <td>{{$s['quantity']}}</td>
                    <td>{{$s['rate']}}</td>
                    <td>{{number_format($s['rate'] * $s['quantity'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-sm-6 mb-5">
        <div class="form-group">
            <label for="name" class="form-label">Session Time:</label>
            <input type="text" name="session_date" id="caseDate" class="form-control" value="{{$case_session->session_date}}">
        </div>

    </div>

    <div class="col-sm-6 mb-5">
        <div class="form-group">
            <label for="name" class="form-label">Status:</label>
            <select class="form-control" name="status" required>
                <option value="Pending" {{$case_session->status == 'Pending' ? 'selected' : ''}}>Pending</option>
                <option value="In Progress" {{$case_session->status == 'In Progress' ? 'selected' : ''}}>In Progress</option>
                <option value="Cancel" {{$case_session->status == 'Cancel' ? 'selected' : ''}}>Cancel</option>
            </select>
        </div>
    </div>


    <div class="col-sm-6 mb-5">
        <div class="form-group ">
            <div class="row2" io-image-input="true">
                <label for="" class="form-label">Before Session</label>
                <div class="needsclick dropzone" id="before-dropzone">

                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-6 mb-5">
        <div class="form-group  mb-5">
            <div class="row2" io-image-input="true">
                <label for="" class="form-label">After Session</label>
                <div class="needsclick dropzone" id="after-dropzone">

                </div>
            </div>
        </div>
    </div>
</div>

<hr>

    <div class="row">
        <div class="form-group col-sm-6 mb-5">
            {{ Form::label('is_paid', 'Is Paid?:', ['class' => 'form-label']) }}
            <br>
            <div class="form-check form-switch">
                <input class="form-check-input w-35px h-20px" name="is_paid" type="checkbox" value="1" {{$case_session->payment_status == "Paid" ? 'checked' : ''}}>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#selectBillDiv').hide();
                function toggleSelectBillDiv() {
                    if ($('input[name="is_paid"]').prop('checked')) {
                        $('#selectBillDiv').show();
                        $('#appointmentBillPaid').prop('required', true);
                    } else {
                        $('#selectBillDiv').hide();
                        $('#appointmentBillPaid').prop('required', false);
                    }
                }
                toggleSelectBillDiv();
                $('input[name="is_paid"]').change(function() {
                    toggleSelectBillDiv();
                });
            });
        </script>

        <div id="selectBillDiv" class="form-group col-sm-3 mb-5">
            {{ Form::label('bill', __('messages.select_bill').':', ['class' => 'form-label']) }}
            <span class="required"></span>
            <select name="bill_id" class="form-select" id="caseSessionBillId" data-control="select2">
                <option>Select Bill</option>
                @foreach($bill as $t)
                    <option value="{{$t->bill_id}}" >{{$t->bill_id}}</option>
                @endforeach
            </select>
        </div>
    </div>


<div class="row">
    <div class="col-12 mb-5">
        <div class="form-group">
            <label for="name" class="form-label">Doctor's remark:</label>
            <textarea class="form-control" name="remark[doctor]" <?= auth()->user()->hasAnyRole(['Doctor', 'Admin']) ? '' : 'readonly' ?>>{{$case_session->remark['doctor'] ?? ''}}</textarea>
        </div>
    </div>
    <div class="col-12 mb-5">
        <div class="form-group">
            <label for="name" class="form-label">Case Handler's remark:</label>
            <textarea class="form-control" required name="remark[case_handler]" <?= auth()->user()->hasAnyRole(['Case Manager', 'Admin']) ? '' : 'readonly' ?>>{{$case_session->remark['case_handler'] ?? ''}}</textarea>
        </div>
    </div>
    <div class="col-12 mb-5">
        <div class="form-group">
            <label for="name" class="form-label">Patient's feedback:</label>
            <textarea class="form-control" name="remark[patient]" <?= auth()->user()->hasAnyRole(['Patient', 'Admin']) ? '' : 'readonly' ?>>{{$case_session->remark['patient'] ?? ''}}</textarea>
        </div>
    </div>
</div>

<div class="row">

    <div class="form-group col-sm-12 d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','id'=>'saveAppointment']) }}
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    </div>
</div>
<?php

use \App\Models\PatientCaseSession;
?>
<script>
    $(document).ready(function() {
        var uploadedBeforeMap = {}
        var canEdit = <?= auth()->user()->hasAnyRole(['Case Manager', 'Admin', 'Doctor']) ? 'true' : 'false' ?>;
        $('#before-dropzone').dropzone({
            url: `{{ route('store-media') }}`,
            maxFilesize: 3, // MB
            addRemoveLinks: canEdit,
            clickable: canEdit,
            acceptedFiles: 'image/*',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('#editCaseSessionForm').append('<input type="hidden" name="before[]" value="' + response.name + '">')
                uploadedBeforeMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedBeforeMap[file.name]
                }
                $('#editCaseSessionForm').find('input[name="before[]"][value="' + name + '"]').remove()
            },
            init: function() {
                <?php

                if (isset($case_session) && $case_session->getMedia(PatientCaseSession::SESSION_BEFORE)) { ?>
                    var files =
                        <?= json_encode($case_session->getMedia(PatientCaseSession::SESSION_BEFORE)) ?>;
                    for (var i in files) {
                        var file = files[i];
                        this.displayExistingFile(file, file.original_url)
                        $('#editCaseSessionForm').append('<input type="hidden" name="before[]" value="' + file.file_name + '">')
                    }
                <?php } ?>
            }
        })
        var uploadedAfterMap = {}
        $('#after-dropzone').dropzone({
            url: `{{ route('store-media') }}`,
            maxFilesize: 3, // MB
            addRemoveLinks: canEdit,
            clickable: canEdit,
            acceptedFiles: 'image/*',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('#editCaseSessionForm').append('<input type="hidden" name="after[]" value="' + response.name + '">')
                uploadedAfterMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedAfterMap[file.name]
                }
                $('#editCaseSessionForm').find('input[name="after[]"][value="' + name + '"]').remove()
            },
            init: function() {
                <?php if (isset($case_session) && $case_session->getMedia(PatientCaseSession::SESSION_AFTER)) { ?>
                    var files =
                        <?= json_encode($case_session->getMedia(PatientCaseSession::SESSION_AFTER)) ?>;
                    for (var i in files) {
                        var file = files[i];
                        this.displayExistingFile(file, file.original_url)
                        $('#editCaseSessionForm').append('<input type="hidden" name="after[]" value="' + file.file_name + '">')
                    }
                <?php } ?>
            }
        })
    })
</script>

<div class="row">
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.operation_report.case_id').(':')  }}</label>
        <span class="fs-5 text-gray-800">{{ $patientCase->case_id}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.case.patient').(':')  }}</label>
        <span class="fs-5 text-gray-800">{{$patientCase->patient->unique_id . ' - ' .$patientCase->patient->patientUser->full_name}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.case.doctor').(':')  }}</label>
        <span class="fs-5 text-gray-800">{{$patientCase->doctor->doctorUser->full_name}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.case.case_handler').(':')  }}</label>
        <span class="fs-5 text-gray-800">{{$patientCase->case_handler->user->full_name}}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.case.case_date').(':')  }}</label>
        <span class="fs-5 text-gray-800">{{\Carbon\Carbon::parse($patientCase->date)->translatedFormat('jS M,Y g:i A') }}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.case.fee').(':')  }}</label>
        <span class="fs-5 text-gray-800">{{ getCurrencyFormat($patientCase->fee) }}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.common.created_at').(':')  }}</label>
        <span class="fs-5 text-gray-800" data-toggle="tooltip" data-placement="right" title="{{ date('jS M, Y', strtotime($patientCase->created_at)) }}">{{ $patientCase->created_at->diffForHumans() }}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.common.last_updated').(':')  }}</label>
        <span class="fs-5 text-gray-800" data-toggle="tooltip" data-placement="right" title="{{ date('jS M, Y', strtotime($patientCase->updated_at)) }}">{{ $patientCase->updated_at->diffForHumans() }}</span>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.common.status').(':')  }}</label>
        <p>
            <span class="badge bg-light-{{($patientCase->status == 1) ? 'success' : 'danger'}}">{{ ($patientCase->status == 1) ? __('messages.common.active') : __('messages.common.de_active') }}</span>
        </p>
    </div>
    <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
        <label class="pb-2 fs-5 text-gray-600">{{ __('messages.common.description').(':')  }}</label>
        <span class="fs-5 text-gray-800">{!! !empty($patientCase->description)?nl2br(e($patientCase->description)):__('messages.common.n/a') !!}</span>
    </div>
    <?php

    use \App\Models\PatientCaseSession;

    $statusType = ['Pending' => 'warning', 'In Progress' => 'info', 'Cancel' => 'danger', 'Completed' => 'success'];
    ?>
    <div class="accordion" id="accordionSession">

        @foreach($patientCase->sessions as $k => $session)
        <div class="accordion-item session-{{$k}}">
            <h2 class="accordion-header" id="heading-{{$k}}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$k}}" aria-expanded="true" aria-controls="collapse-{{$k}}">
                    Session #{{$k + 1}}
                </button>
            </h2>
            <div id="collapse-{{$k}}" class="accordion-collapse collapse" aria-labelledby="heading-{{$k}}" data-bs-parent="#accordionSession">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label class="pb-2 fs-5 text-gray-600">Session Date:</label>
                            {{\Carbon\Carbon::parse($session->session_date)->translatedFormat('jS M,Y g:i A')}}

                        </div>
                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label class="pb-2 fs-5 text-gray-600">Session Status:</label>
                            <span class="badge align-self-start bg-light-{{ $statusType[$session->status] }}">
                                <div>{{ $session->status }}</div>
                            </span>
                        </div>
                        <div class="col-md-12 d-flex flex-column mb-md-10 mb-5">
                            <label class="pb-2 fs-5 text-gray-600">Doctor's remark:</label>
                            <div>{{ $session->remark['doctor'] ?? 'N/A' }}</div>

                        </div>
                        <div class="col-md-12 d-flex flex-column mb-md-10 mb-5">
                            <label class="pb-2 fs-5 text-gray-600">Case Handler's remark:</label>
                            <div>{{ $session->remark['case_handler'] ?? 'N/A' }}</div>

                        </div>
                        <div class="col-md-12 d-flex flex-column mb-md-10 mb-5">
                            <label class="pb-2 fs-5 text-gray-600">Patient's remark:</label>
                            <div>{{ $session->remark['patient'] ?? 'N/A' }}</div>

                        </div>
                        <div class="col-12 d-flex flex-column mb-md-10 mb-5">
                            <label class="pb-2 fs-5 text-gray-600">Services:</label>
                            <div class="table-responsive-sm">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr class="fw-bold fs-6 text-muted">
                                            <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.service') }}</th>
                                            <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.rate') }}</th>
                                            <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.qty') }}</th>
                                            <th class="text-right form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="package-service-item-container-{{$k}}">
                                        @foreach($session->services as $s)
                                        <tr>
                                            <td>{{$services[$s['service_id']]}}</td>
                                            <td>{{$s['rate']}}</td>
                                            <td>{{$s['quantity']}}</td>
                                            <td>{{number_format($s['rate'] * $s['quantity'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-column mb-md-10 mb-5">
                            <label class="pb-2 fs-5 text-gray-600">Images before session:</label>
                            <div class="row">
                                @foreach($session->getMedia(PatientCaseSession::SESSION_BEFORE) as $v)
                                <div class="col-md-2 col-sm-4 col-6">
                                    <a data-gallery="before" data-session="{{$k}}" href="{{$v->original_url}}">
                                        <img src="{{$v->original_url}}" alt="{{$v->file_name}}" class="img-fluid">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-column mb-md-10 mb-5">
                            <label class="pb-2 fs-5 text-gray-600">Images after session:</label>
                            <div class="row">
                                @foreach($session->getMedia(PatientCaseSession::SESSION_AFTER) as $v)
                                <div class="col-md-2 col-sm-4 col-6">
                                    <a data-gallery="after" data-session="{{$k}}" href="{{$v->original_url}}">
                                        <img src="{{$v->original_url}}" alt="{{$v->file_name}}" class="img-fluid">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    $('[data-gallery=before]').click(function(e) {
        e.preventDefault();
        var items = [],
            options = {
                index: $(this).index()
            };
        var session = $(this).data('session')
        $(`[data-gallery=before][data-session=${session}]`).each(function() {
            let src = $(this).attr('href');
            items.push({
                src: src
            });
        });
        new PhotoViewer(items, options);
    });
    $('[data-gallery=after]').click(function(e) {
        e.preventDefault();
        var items = [],
            options = {
                index: $(this).index()
            };
        var session = $(this).data('session')
        $(`[data-gallery=after][data-session=${session}]`).each(function() {
            let src = $(this).attr('href');
            items.push({
                src: src
            });
        });
        new PhotoViewer(items, options);
    });
</script>
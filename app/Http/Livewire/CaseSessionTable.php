<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\PatientCase;
use App\Models\PatientCaseSession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CaseSessionTable extends LivewireTableComponent
{
    use WithPagination;

    protected $model = PatientCaseSession::class;



    public $showFilterOnHeader = true;


    protected $FilterComponent = ['patient_case_sessions.filter-button', Appointment::STATUS_ARR];

    protected $startDate = '';

    protected $endDate = '';

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage', 'changeDateFilter'];

    public function resetPage($pageName = 'page')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }

    public function changeDateFilter($param, $value)
    {
        $this->resetPage($this->getComputedPageName());
        $this->startDate = $value[0];
        $this->endDate = $value[1];
        $this->setBuilder($this->builder());
    }

    public function changeFilter($param, $value)
    {
        $this->resetPage($this->getComputedPageName());
        $this->startDate = $value[0];
        $this->endDate = $value[1];
        $this->statusFilter = $value[2];
        $this->setBuilder($this->builder());
    }

    public function configure(): void
    {
        $this->setDefaultSort('patient_case_sessions.created_at', 'desc');
        $this->setQueryStringStatus(false);
        $this->setPrimaryKey('id');
        $this->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.case.patient'), 'patient.patientUser.email')
                ->hideIf('patient.patientUser.email')
                ->searchable(),

            Column::make(__('messages.case.patient'), 'doctor.doctorUser.email')
                ->hideIf('doctor.doctorUser.email')
                ->searchable(),

            Column::make('Session No.', 'session_no')
                ->label(function ($row) {
                    $no = $row->no;
                    $case = $row->case;
                    return view('patient_case_sessions.columns.session', compact('no', 'case'));
                }),
            Column::make(__('messages.case.patient'), 'patient.patientUser.first_name')
                ->view('patient_case_sessions.columns.patient_name')
                ->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('patient.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                )
                ->sortable(
                    function (Builder $query, $direction) {
                        return $query->orderBy(User::select('first_name')->whereColumn('id', 'patients.user_id'), $direction);
                    }
                ),
            Column::make('Patient Id', 'patient.unique_id')
                ->searchable(),
            Column::make('Patient Phone', 'patient.patientUser.phone'),
            Column::make(__('messages.case.doctor'), 'doctor.doctorUser.first_name')
                ->view('patient_case_sessions.columns.doctor_name')
                ->sortable(
                    function (Builder $query, $direction) {
                        return $query->orderBy(User::select('first_name')->whereColumn('id', 'doctors.user_id'), $direction);
                    }
                )
                ->searchable(
                    function (Builder $query, $direction) {
                        return $query->whereHas('doctor.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                        });
                    }
                ),
            Column::make(__('messages.case.case_handler'), 'case_handler.user.first_name')
                ->view('patient_case_sessions.columns.handler_name'),
            Column::make(__('messages.case.patient'), 'patient_id')->hideIf(1),
            Column::make(__('messages.case.doctor'), 'doctor_id')->hideIf(1),
            Column::make(__('messages.case.case_handler'), 'case_handler_id')->hideIf(1),
            Column::make(__('messages.appointment.date'), 'session_date')
                ->label(function ($row) {
                    $date = Carbon::parse($row->session_date);
                    $time = $date->isoFormat('LT');
                    $dt = $date->translatedFormat('jS M, Y');
                    return view('patient_case_sessions.columns.date', compact('time', 'dt'));
                }),
            Column::make('Status', 'status')
                ->label(function ($row) {
                    $status = $row->status;
                    $statusType = ['Pending' => 'warning', 'In Progress' => 'info', 'Cancel' => 'danger', 'Completed' => 'success'];
                    $bg = $statusType[$status];
                    return view('patient_case_sessions.columns.status', compact('bg', 'status'));
                }),
            Column::make(__('messages.common.action'), 'session.id')
                ->label(function ($row) {
                    return view('patient_case_sessions.action', compact('row'));
                }),

            // Column::make('Consultation Charge', 'fee')
            //     ->view('patient_case_sessions.columns.amount'),
        ];
    }

    public function builder(): Builder
    {
        $query = PatientCase::join('patient_case_sessions', 'patient_case_sessions.case_id', '=', 'patient_cases.id')
            ->select(['patient_case_sessions.*', 'patient_case_sessions.id as session_id', 'patient_case_sessions.status', 'patient_cases.case_id as case'])
            ->with(['patient', 'patient.user', 'doctor', 'doctor.user', 'case_handler', 'case_handler.user', 'sessions'])
            ->orderBy('patient_case_sessions.session_date')
            ->orderBy('patient_case_sessions.no');

        if (!getLoggedinDoctor()) {
            if (getLoggedinPatient()) {
                //                $query = Appointment::query()->select('patient_case_sessions.*')->with('patient', 'doctor', 'department');
                $patient = Auth::user();
                $query->whereHas('patient', function (Builder $query) use ($patient) {
                    $query->where('user_id', '=', $patient->id);
                });
            }

            if (auth()->user()->hasRole('Case Manager')) {

                $query->where('case_handler_id', '=', auth()->user()->owner_id);
            }
        } else {
            $doctorId = Doctor::where('user_id', getLoggedInUserId())->first();
            $query = $query->where('doctor_id', $doctorId->id);
        }

        $query->when(isset($this->statusFilter), function (Builder $q) {
            if ($this->statusFilter == 2) {
            } else {
                $q->where('is_completed', $this->statusFilter);
            }
        });
        $query->when(isset($this->startDate) && $this->endDate, function (Builder $q) {
            $q->whereBetween('session_date', [$this->startDate, $this->endDate]);
        });

        return $query;
    }
}

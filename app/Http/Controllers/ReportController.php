<?php

namespace App\Http\Controllers;

use App\Http\Livewire\SuperAdminCurrencyTable;
use App\Imports\ImportLeads;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Doctor;
use App\Models\HospitalType;
use App\Models\ImportLeadModel;
use App\Models\Patient;
use App\Models\PatientCase;
use App\Models\PatientCaseSession;
use App\Models\SuperAdminCurrencySetting;
use App\Models\SuperAdminSetting;
use App\Models\TeleCaller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['total_uploaded_leads'] = ImportLeadModel::sum('uploaded_lead_count');
        $data['total_converted_leads'] = TeleCaller::query()
        ->join('users as telecaller', 'tele_callers.user_id', '=', 'telecaller.id')
        ->join('appointments', 'tele_callers.user_id', '=', 'appointments.telecaller_id')
        ->join('patients', 'appointments.patient_id', '=', 'patients.id')
        ->join('users as patient_user', 'patients.user_id', '=', 'patient_user.id')
        ->leftJoin('users', 'patients.user_id', '=', 'users.id')
        ->count();

        $telecallers = DB::table('tele_callers')
        ->join('users', 'tele_callers.user_id', '=', 'users.id')
        ->select('tele_callers.user_id', 'users.first_name as fname', 'users.last_name as lname')
        ->get();

        return view('super_admin.reports.index', compact('data','telecallers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function salesReport()
    {
        // $data['appointments'] = Appointment::count();

        // $data['patients'] = Patient::count();

        // $data['case-sessions'] = PatientCaseSession::count();

        // $data['cases'] = PatientCase::count();

        // $data['total-revenue'] = Bill::sum('paid_amount');

        // $TotalAmount = Bill::sum('amount');

        // $data['due-amount'] = $TotalAmount - $data['total-revenue'];

        // return view('super_admin.sales_report.index', compact('data'));

        return view('super_admin.sales_report.index');

    }

    public function telecallerRecord(Request $request)
    {
        $query = DB::table('import_lead_models')
        ->whereDate('import_date', '>=', $request->get('startDate'))
        ->whereDate('import_date', '<=', $request->get('endDate'))
        ->sum('uploaded_lead_count');

        $sumUploadedLeads = (int) $query;

        $telecount = DB::table('appointments')
                    ->where('telecaller_id','=',$request->get('tele_id'))
                    ->whereDate('opd_date', '>=', $request->get('startDate'))
                    ->whereDate('opd_date', '<=', $request->get('endDate'))
                    ->count();

        return response()->json(['sumUploadedLeads' => $sumUploadedLeads , 'telecount' => $telecount]);
    }
}

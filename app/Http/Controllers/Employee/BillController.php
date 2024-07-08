<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\AppBaseController;
use App\Models\Bill;
use App\Models\DoctorOPDCharge;
use App\Models\PatientCase;
use App\Models\PatientCaseSession;
use App\Repositories\BillRepository;
use \PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Response;

class BillController extends AppBaseController
{
    /** @var BillRepository */
    private $billRepository;

    public function __construct(BillRepository $billRepo)
    {
        $this->billRepository = $billRepo;
    }

    /**
     * Display a listing of the Bill.
     *
     * @return Factory|View|Response
     *
     * @throws Exception
     */
    public function index(Request $request): View
    {
        return view('employees.bills.index');
    }

    /**
     * Display the specified Bill.
     *
     * @return Factory|View
     */
    public function show(Bill $bill)
    {
        if (getLoggedInUser()->hasRole('Patient')) {
            if (getLoggedInUser()->owner_id != $bill->patient_id) {
                return Redirect::back();
            }
        }

        $bill = Bill::with(['billItems.medicine', 'patient'])->find($bill->id);
        $bill = Bill::with(['billItems.medicine', 'patient', 'patientAdmission'])->find($bill->id);
        $admissionDate = Carbon::parse($bill->patientAdmission->admission_date);
        $dischargeDate = Carbon::parse($bill->patientAdmission->discharge_date);
        $bill->totalDays = $admissionDate->diffInDays($dischargeDate) + 1;

        return view('employees.bills.show')->with('bill', $bill);
    }

    public function convertToPdf(Bill $bill)
    {
        if(app()->getLocale() == "zh"){
            app()->setLocale("en");
        }
        $bill->billItems;
        $data = $this->billRepository->getSyncListForCreate();
        $data['bill'] = $bill;
        $pdf = PDF::loadView('bills.bill_pdf', $data);

        return $pdf->stream('bill.pdf');
    }

    public function getDoctorFee(Request $request)
    {
        $doctorId = $request->get('doctor_id');        
        $doctorFee = DoctorOPDCharge::where('doctor_id','=',$doctorId)->select('standard_charge','new_patient_charge')->get();
        return response()->json(['data' => $doctorFee]); 
    }

    public function getCaseDetails(Request $request)
    {
        $caseId = $request->get('case_id');   
        $caseList = DB::table('patient_case_sessions')
        ->join('patient_cases', 'patient_cases.id', '=', 'patient_case_sessions.case_id')
        ->join('packages','patient_cases.package_id','=','packages.id')
        ->where('patient_case_sessions.case_id', '=', $caseId)
        ->select('patient_case_sessions.services', 'patient_cases.fee','patient_cases.case_id','packages.name as packname')
        ->get();
        return response()->json(['data' => $caseList]); 
    }
}

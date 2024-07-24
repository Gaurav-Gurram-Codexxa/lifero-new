<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Expense;
use App\Models\ImportLeadModel;
use App\Models\Income;
use App\Models\Patient;
use App\Models\PatientCase;
use App\Models\PatientCaseSession;
use App\Models\Subscription;
use App\Models\TeleCaller;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardRepository
 */
class DashboardRepository
{
    /**
     * @throws Exception
     */
    public function getIncomeExpenseReport(array $input): array
    {
        $dates = $this->getDate($input['start_date'], $input['end_date']);

        $incomes = Income::all();
        $expenses = Expense::all();

        //Income report
        $data = [];
        foreach ($dates['dateArr'] as $cDate) {
            $incomeTotal = 0;
            foreach ($incomes as $row) {
                $chartDates = $cDate;
                $incomeDates = trim(substr($row['date'], 0, 10));
                if ($chartDates == $incomeDates) {
                    $incomeTotal += $row['amount'];
                }
            }
            $incomeTotalArray[] = $incomeTotal;
            $dateArray[] = $cDate;
        }

        //Expense report
        foreach ($dates['dateArr'] as $cDate) {
            $expenseTotal = 0;
            foreach ($expenses as $row) {
                $chartDates = $cDate;
                $expenseDates = trim(substr($row['date'], 0, 10));
                if ($chartDates == $expenseDates) {
                    $expenseTotal += $row['amount'];
                }
            }
            $expenseTotalArray[] = $expenseTotal;
        }

        $data['incomeTotal'] = $incomeTotalArray;
        $data['expenseTotal'] = $expenseTotalArray;
        $data['date'] = $dateArray;

        return $data;
    }

    /**
     * @throws Exception
     */
    public function getDate(string $startDate, string $endDate): array
    {
        $dateArr = [];
        $subStartDate = '';
        $subEndDate = '';
        if (! ($startDate && $endDate)) {
            $data = [
                'dateArr' => $dateArr,
                'startDate' => $subStartDate,
                'endDate' => $subEndDate,
            ];

            return $data;
        }
        $end = trim(substr($endDate, 0, 10));
        $start = Carbon::parse($startDate)->toDateString();
        /** @var \Illuminate\Support\Carbon $startDate */
        $startDate = Carbon::createFromFormat('Y-m-d', $start);
        /** @var \Illuminate\Support\Carbon $endDate */
        $endDate = Carbon::createFromFormat('Y-m-d', $end);

        while ($startDate <= $endDate) {
            $dateArr[] = $startDate->copy()->format('Y-m-d');
            $startDate->addDay();
        }
        $start = current($dateArr);
        $endDate = end($dateArr);
        $subStartDate = Carbon::parse($start)->startOfDay()->format('Y-m-d H:i:s');
        $subEndDate = Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s');

        $data = [
            'dateArr' => $dateArr,
            'startDate' => $subStartDate,
            'endDate' => $subEndDate,
        ];

        return $data;
    }

    /**
     * @return int[]
     */
    public function getTotalActiveDeActiveHospitalPlans(): array
    {
        $activePlansCount = 0;
        $deActivePlansCount = 0;
        $subscriptions = Subscription::whereStatus(Subscription::ACTIVE)->get();
        foreach ($subscriptions as $sub) {
            if (! $sub->isExpired()) {   // active plans
                $activePlansCount++;
            } else {
                $deActivePlansCount++;
            }
        }

        return ['activePlansCount' => $activePlansCount, 'deActivePlansCount' => $deActivePlansCount];
    }

    public function totalFilterDay($formatStartDate, $formatEndDate): array
    {
        $period = CarbonPeriod::create($formatStartDate, $formatEndDate);


        $data['appointments'] =DB::table('appointments')
        ->whereDate('opd_date', '>=', $formatStartDate)
        ->whereDate('opd_date', '<=', $formatEndDate)
        ->count();

        $data['patients'] = DB::table('patients')
        ->whereDate('created_at', '>=', $formatStartDate)
        ->whereDate('created_at', '<=', $formatEndDate)
        ->count();

        $data['cases'] = DB::table('patient_cases')
        ->whereDate('created_at', '>=', $formatStartDate)
        ->whereDate('created_at', '<=', $formatEndDate)
        ->count();


        $data['case_sessions'] = DB::table('patient_case_sessions')
        ->whereDate('created_at', '>=', $formatStartDate)
        ->whereDate('created_at', '<=', $formatEndDate)
        ->count();

        $paidAmount = DB::table('bills')
        ->whereDate('created_at', '>=', $formatStartDate)
        ->whereDate('created_at', '<=', $formatEndDate)
        ->sum('paid_amount');

        $TotalAmount = DB::table('bills')
        ->whereDate('created_at', '>=', $formatStartDate)
        ->whereDate('created_at', '<=', $formatEndDate)
        ->sum('amount');

        $data['total_amount'] = $TotalAmount;

        $data['total_revenue'] = formatCurrency($paidAmount,2);

        $data['due_amount'] = formatCurrency($TotalAmount - $paidAmount,2);

        $dateArr = [];

        $totalAmounts = [];

        $paidAmounts =[];

        $dueAmounts =[];

        foreach ($period as $date) {

            $formattedDate = $date->format('Y-m-d');
            $dateArr[] = $date->format('d-m-y');
            $income[] = $this->totalFilterReport($date);

            $totalAmount = DB::table('bills')
                        ->whereDate('created_at', $formattedDate)
                        ->sum('amount');

            $totalAmounts[] = $totalAmount;

            $paidAmount = DB::table('bills')
                        ->whereDate('created_at', $formattedDate)
                        ->sum('paid_amount');

            $paidAmounts[] = $paidAmount;

            $dueAmounts []= ($totalAmount-$paidAmount);

        }
        $data['days'] = $dateArr;

        $data['total_amount_arr'] = $totalAmounts;

        $data['total_revenue_arr'] = $paidAmounts;

        $data['due_amount_arr'] = $dueAmounts;


        $data['income'] = [
            'label' => trans('messages.income', [], getLoggedInUser()->language),
            'data' => $income,
            'fill' => 'false',
            'borderColor' => 'rgb(153, 102, 255)',
            'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
            'borderWidth' => 1,
            'tension' => 0.4,
        ];

        return $data;
    }

    public function totalFilterReport($date)
    {
        return Bill::where('status', Bill::PAID)->whereDate('created_at', $date)->sum('paid_amount');
    }

    public function totalFilterDayLead($formatStartDate, $formatEndDate): array
    {
        $period = CarbonPeriod::create($formatStartDate, $formatEndDate);

        $dateArr = [];

        $leads =[];

        $convertedLeads = [];

        foreach ($period as $date)
        {
            $dateArr[] = $date->format('d-m-y');
            $leads[] = $this->totalFilterLeadReport($date);
            $convertedLeads[] = $this->totalFilterLeadConvertedReport($date);
        }
        $data['days'] = $dateArr;
        $data['leads'] = $leads;
        $data['convertedLeads'] = $convertedLeads;

        return $data;
    }

    /**
     * @return int|mixed
     */

    public function totalFilterLeadReport($date)
    {
        return ImportLeadModel::whereDate('created_at',$date)->sum('uploaded_lead_count');
    }

    public function totalFilterLeadConvertedReport($date)
    {

        return TeleCaller::join('users as telecaller', 'tele_callers.user_id', '=', 'telecaller.id')
        ->join('appointments', 'tele_callers.user_id', '=', 'appointments.telecaller_id')
        ->join('patients', 'appointments.patient_id', '=', 'patients.id')
        ->join('users as patient_user', 'patients.user_id', '=', 'patient_user.id')
        ->whereDate('appointments.created_at',$date)
        ->count();

    }



}

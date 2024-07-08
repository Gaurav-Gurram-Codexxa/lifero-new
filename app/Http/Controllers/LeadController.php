<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Jobs\ImportLeadJob;
use App\Models\Address;
use App\Models\EmployeePayroll;
use App\Models\Lead;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\LeadRepository;
use DB;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class LeadController extends AppBaseController
{
    /** @var LeadRepository */
    private $leadRepository;

    public function __construct(LeadRepository $leadRepo)
    {
        $this->leadRepository = $leadRepo;
    }

    /**
     * Display a listing of the Lead.
     *
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $data['statusArr'] = Lead::STATUS_ARR;
        return view('leads.index', $data);
    }

    /**
     * Show the form for creating a new Lead.
     *
     * @return Factory|View
     */
    public function create(): View
    {
        return view('leads.create');
    }

    /**
     * Store a newly created Lead in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateLeadRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['region_code'] = regionCode($input['prefix_code']);
        $input['status'] = isset($input['status']) ? 1 : 0;

        $lead = $this->leadRepository->store($input);

        Flash::success(__('messages.flash.lead_save'));

        return redirect(route('leads.index'));
    }

    /**
     * Display the specified Lead.
     *
     * @return Factory|View
     */
    public function show(Lead $lead)
    {
        if (!canAccessRecord(Lead::class, $lead->id)) {
            return Redirect::back();
        }
        return view('lead.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified Lead.
     *
     * @return Factory|View
     */
    public function edit(Lead $lead)
    {
        if (!canAccessRecord(Lead::class, $lead->id)) {
            Flash::error(__('messages.flash.not_allow_access_record'));

            return Redirect::back();
        }

        if (auth()->user()->hasRole('Tele Caller')) {
            $lead->update(['opened_by' => auth()->user()->id]);
        }

        return view('leads.edit', compact('lead'));
    }

    /**
     * Update the specified Lead in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Lead $lead, UpdateLeadRequest $request): RedirectResponse
    {
        if ($request->has('by_mistake')) {
            $lead->update(['opened_by' => 0]);

            DB::table('lead_closes')->insert([
                'lead_id' => $lead->id,
                'user_id' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Flash::success('Lead closed successfully');
            return redirect(route('leads.index'));
        }


        $input = $request->all();
        $input['status'] = $input['status'];

        $disposition = $lead->disposition;
        $status = $lead->status;

        $lead->disposition = $request->disposition;
        $lead->status = $request->status;

        $isDispositionDirty = $lead->isDirty('disposition');
        $isStatusDirty = $lead->isDirty('status');

        $isTeleCaller = auth()->user()->hasRole('Tele Caller');

        if (($isDispositionDirty || $isStatusDirty) && $isTeleCaller) {
            $lead->update(['opened_by' => 0]);
        }

        $remark = '';

        if ($isDispositionDirty) {
            $remark .= "Disposition changed from <strong>{$disposition}</strong> to <strong>{$request->disposition}</strong><br>";
        }

        if ($isStatusDirty) {
            $remark .= "Status changed from <strong>{$status}</strong> to <strong>{$request->status}</strong><br>";
        }

        if ($request->remark)
            $remark .= "Remark: $request->remark";

        if ($remark) {
            $remarks = $lead->remarks ?? [];
            $user = auth()->user();
            $input['remarks'] = [[
                'created_at' => now(),
                'remark' => $remark,
                'remark_by' => trim("{$user->first_name} {$user->last_name}")
            ], ...$remarks];
        }



        $lead = $this->leadRepository->update($lead, $input);

        Flash::success(__('messages.flash.lead_update'));

        return redirect(route('leads.index'));
    }

    /**
     * Remove the specified Lead from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Lead $lead): JsonResponse
    {
        if (!canAccessRecord(Lead::class, $lead->id)) {
            return $this->sendError(__('messages.flash.lead_cant_delete'));
        }

        $lead->delete();

        return $this->sendSuccess(__('messages.flash.lead_delete'));
    }

    public function activeDeactiveStatus(int $id): JsonResponse
    {
        $lead = Lead::findOrFail($id);
        $status = !$lead->user->status;
        $lead->user()->update(['status' => $status]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }

    public function appointment(Lead $lead)
    {
        $patient = Patient::join('users', 'users.id', '=', 'patients.user_id')
            ->where('phone', $lead->contact)
            ->select(['patients.id'])
            ->first();

        if ($patient == null) {
            $user =  User::create([
                'first_name' => $lead->name,
                'last_name' => '',
                'email' => $lead->email,
                'phone' => $lead->contact,
                'status' => 1,
            ]);
            $patient = Patient::create(['user_id' => $user->id]);
            $patient->update(['unique_id' => 'L' . str_pad("{$patient->id}", 5, '0', STR_PAD_LEFT)]);

            $ownerId = $patient->id;
            $ownerType = Patient::class;

            $user->update(['owner_id' => $ownerId, 'owner_type' => $ownerType]);

            Address::create([
                'address1' => $lead->address,
                'address2' => '',
                'city' => $lead->city,
                'zip' => '',
                'owner_id' => $ownerId,
                'owner_type' => $ownerType
            ]);
        }

        return redirect()->route('appointments.create', ['p' => $patient->id]);
    }

    function import(Request $request)
    {
        $file = $request->file('file')->move(public_path('temp'), $request->file('file')->getClientOriginalName());

        ImportLeadJob::dispatch($file->getRealPath(), tenant('id'));
        Flash::success('Lead imported successfully');
        return redirect()->route('leads.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeleCallerRequest;
use App\Http\Requests\UpdateTeleCallerRequest;
use App\Models\TeleCaller;
use App\Models\EmployeePayroll;
use App\Repositories\TeleCallerRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TeleCallerController extends AppBaseController
{
    /** @var TeleCallerRepository */
    private $teleCallerRepository;

    public function __construct(TeleCallerRepository $teleCallerRepo)
    {
        $this->teleCallerRepository = $teleCallerRepo;
    }

    /**
     * Display a listing of the TeleCaller.
     *
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $data['statusArr'] = TeleCaller::STATUS_ARR;
        return view('tele_callers.index', $data);
    }

    /**
     * Show the form for creating a new TeleCaller.
     *
     * @return Factory|View
     */
    public function create(): View
    {
        $bloodGroup = getBloodGroups();

        return view('tele_callers.create', compact('bloodGroup'));
    }

    /**
     * Store a newly created TeleCaller in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateTeleCallerRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['region_code'] = regionCode($input['prefix_code']);
        $input['status'] = isset($input['status']) ? 1 : 0;

        $teleCaller = $this->teleCallerRepository->store($input);

        Flash::success(__('messages.flash.tele_caller_save'));

        return redirect(route('tele-callers.index'));
    }

    /**
     * Display the specified TeleCaller.
     *
     * @return Factory|View
     */
    public function show(TeleCaller $teleCaller)
    {
        if (!canAccessRecord(TeleCaller::class, $teleCaller->id)) {
            return Redirect::back();
        }

        $payrolls = $teleCaller->payrolls;

        return view('tele_caller.show', compact('teleCaller', 'payrolls'));
    }

    /**
     * Show the form for editing the specified TeleCaller.
     *
     * @return Factory|View
     */
    public function edit(TeleCaller $tele_caller)
    {
        if (!canAccessRecord(TeleCaller::class, $tele_caller->id)) {
            Flash::error(__('messages.flash.not_allow_access_record'));

            return Redirect::back();
        }

        $user = $tele_caller->user;
        $bloodGroup = getBloodGroups();

        return view('tele_callers.edit', compact('user', 'tele_caller', 'bloodGroup'));
    }

    /**
     * Update the specified TeleCaller in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function update(TeleCaller $tele_caller, UpdateTeleCallerRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
        $input['region_code'] = regionCode($input['prefix_code']);
        $tele_caller = $this->teleCallerRepository->update($tele_caller, $input);

        Flash::success(__('messages.flash.tele_caller_update'));

        return redirect(route('tele-callers.index'));
    }

    /**
     * Remove the specified TeleCaller from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(TeleCaller $tele_caller): JsonResponse
    {
        if (!canAccessRecord(TeleCaller::class, $tele_caller->id)) {
            return $this->sendError(__('messages.flash.tele_caller_cant_delete'));
        }

        $empPayRollResult = canDeletePayroll(
            EmployeePayroll::class,
            'owner_id',
            $tele_caller->id,
            $tele_caller->user->owner_type
        );
        if ($empPayRollResult) {
            return $this->sendError(__('messages.flash.tele_caller_cant_delete'));
        }
        $tele_caller->user()->delete();
        $tele_caller->address()->delete();
        $tele_caller->delete();

        return $this->sendSuccess(__('messages.flash.tele_caller_delete'));
    }

    public function activeDeactiveStatus(int $id): JsonResponse
    {
        $teleCaller = TeleCaller::findOrFail($id);
        $status = !$teleCaller->user->status;
        $teleCaller->user()->update(['status' => $status]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }
}

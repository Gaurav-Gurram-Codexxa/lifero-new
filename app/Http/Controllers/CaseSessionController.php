<?php

namespace App\Http\Controllers;

use App\Models\PatientCase;
use App\Models\PatientCaseSession;
use App\Models\Service;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

/**
 * Class PatientCaseSessionController
 */
class CaseSessionController extends AppBaseController
{

    /**
     * Display a listing of the PatientCaseSession.
     *
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $statusArr = [];
        return view('patient_case_sessions.index', compact('statusArr'));
    }

    /**
     * Display the specified PatientCaseSession.
     *
     * @return Factory|View|RedirectResponse
     */
    public function edit(PatientCaseSession $case_session): View
    {
        $case_session->load(['case', 'case.patient.user', 'case.doctor.user', 'case.case_handler.user']);
        $ids = array_map(fn ($e) => $e['service_id'], $case_session->services);
        $services = Service::whereIn('id', $ids)->get()->pluck('name', 'id');
        return view('patient_case_sessions.edit', compact('case_session', 'services'));
    }

    /**
     * Display the specified PatientCaseSession.
     *
     * @return Factory|View|RedirectResponse
     */
    public function show(PatientCaseSession $case_session): View
    {
        return view('patient_case_sessions.show')->with('PatientCaseSession', $case_session);
    }

    /**
     * Update the specified PatientCaseSession in storage.
     */
    public function update(PatientCaseSession $case_session, Request $request)
    {
        $status = $request->status;


        $beforeCollection = $case_session->getMedia(PatientCaseSession::SESSION_BEFORE);
        $before = $request->input('before', []);

        foreach ($beforeCollection as $media) {
            if (!in_array($media->file_name, $before)) {
                $media->delete();
            }
        }
        $beforeCollection = $beforeCollection->pluck('file_name')->toArray();
        foreach ($before as $file) {
            if (!in_array($file, $beforeCollection)) {
                $case_session->addMedia(public_path('temp/' . $file))->toMediaCollection(PatientCaseSession::SESSION_BEFORE);
            }
        }

        $afterCollection = $case_session->getMedia(PatientCaseSession::SESSION_AFTER);
        $after = $request->input('after', []);

        foreach ($afterCollection as $media) {
            if (!in_array($media->file_name, $after)) {
                $media->delete();
            }
        }
        $afterCollection = $afterCollection->pluck('file_name')->toArray();
        foreach ($after as $file) {
            if (!in_array($file, $afterCollection)) {
                $case_session->addMedia(public_path('temp/' . $file))->toMediaCollection(PatientCaseSession::SESSION_AFTER);
            }
        }

        if (count($after)) {
            $status = 'Completed';
        }



        $case_session->update([
            'session_date' => $request->session_date,
            'status' => $status,
            'remark' => $request->remark
        ]);

        $sessions = PatientCaseSession::where('case_id', $case_session->case_id)
            ->orderBy('no')
            ->get();

        $completed = 0;
        $in_progress = 0;
        foreach ($sessions as $session) {
            if ($session->status == 'Completed') {
                $completed++;
            }

            if ($session->status == 'In Progress') {
                $in_progress++;
            }
        }

        $status = PatientCase::PENDING;

        if (count($sessions) == $completed) {
            $status = PatientCase::CLOSED;
        } else if ($in_progress > 0) {
            $status = PatientCase::IN_PROGRESS;
        }

        PatientCase::find($case_session->case_id)->update(['status' => $status]);
        Flash::success("Session updated successfully");
        return redirect(route('case-sessions.index'));
    }

    public function uploadMedia(Request $request)
    {
        $path = public_path('temp');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}

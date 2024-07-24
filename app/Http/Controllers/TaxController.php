<?php

namespace App\Http\Controllers;

use App\Models\TaxModel;
use Flash;
use Illuminate\Http\Request;
use App\Repositories\TaxRepository;
use Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TaxController extends AppBaseController
{
    /** @var TaxRepository */
    private $taxRepository;

    public function __construct(TaxRepository $taxRepo)
    {
        $this->taxRepository = $taxRepo;
    }

    /**
     * Display a listing of the Tax.
     *
     * @return Factory|View
     *
     * @throws Exception
     */

    public function index()
    {
        return view('super_admin.tax.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.tax.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->taxRepository->store($input);
        Flash::success(__('messages.flash.tax_added'));
        if($request->from) {
            return redirect()->route('super_admin.tax.create');
        }
        return redirect(route('super.admin.tax.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id , TaxModel $tax)
    {
        if (!canAccessRecord(TaxModel::class, $tax->id)) {
            return Redirect::back();
        }
        return view('super_admin.tax.show', compact('tax',$tax));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaxModel $tax)
    {
        if (!canAccessRecord(TaxModel::class, $tax->id)) {
            Flash::error(__('messages.flash.not_allow_access_record'));

            return Redirect::back();
        }
        return view('super_admin.tax.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request)
    {
        $input = $request->all();
        $tax = $this->taxRepository->updateTax($id,$input);
        Flash::success(__('messages.flash.tax_updated'));
        return redirect(route('super.admin.tax.index'));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(int $id): JsonResponse
    {
        $user = TaxModel::find($id);
        $user->delete();
        return $this->sendSuccess(__('messages.flash.tax_deleted'));
    }

}

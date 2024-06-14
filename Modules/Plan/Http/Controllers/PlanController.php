<?php

namespace Modules\Plan\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Plan\Entities\Plan;
use Modules\Plan\Http\Requests\PlanFormRequest;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        if (! userCan('plan.view')) {
            return abort(403);
        }
        try {
            $data['plans'] = Plan::all();
            $data['one_time_plans'] = $data['plans']->where('plan_payment_type', 'one_time');
            $data['recurring_plans'] = $data['plans']->where('plan_payment_type', 'recurring');

            return view('plan::index', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        if (! userCan('plan.create')) {
            return abort(403);
        }

        return view('plan::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(PlanFormRequest $request)
    {
        if (! userCan('plan.create')) {
            return abort(403);
        }

        if ($request->interval && $request->interval == 'custom_date') {
            $request->validate([
                'custom_interval_days' => 'required|numeric|min:0',
            ]);
        }
        try {
            Plan::create($request->all());

            flashSuccess('Plan Created Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit(Plan $plan)
    {
        if (! userCan('plan.update')) {
            return abort(403);
        }
        try {
            return view('plan::edit', compact('plan'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(PlanFormRequest $request, Plan $plan)
    {
        if (! userCan('plan.update')) {
            return abort(403);
        }

        if ($request->interval && $request->interval == 'custom_date') {
            $request->validate([
                'custom_interval_days' => 'required|numeric|min:1',
            ]);
        }
        try {

            $plan->update($request->all());

            flashSuccess('Plan Updated Successfully');

            return redirect()->route('module.plan.index');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy(Plan $plan)
    {
        if (! userCan('plan.delete')) {
            return abort(403);
        }
        try {

            $plan->delete();

            flashSuccess('Plan Deleted Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function allTransactions()
    {
        try {

            $transactions = Transaction::with('plan')
                ->latest()
                ->get();

            return view('plan::transactions', compact('transactions'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\PlanUpdateNotification;
use App\Services\Admin\Order\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Plan\Entities\Plan;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        abort_if(! userCan('order.view'), 403);
        try {
            $data['transactions'] = Transaction::with('customer', 'plan')
                ->adminFilter()
                ->latest()
                ->paginate(20)
                ->withQueryString();

            $data['customers'] = User::latest()->get(['id', 'name', 'email']);
            $data['plans'] = Plan::latest()->get();

            return view('admin.order.index', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Create Order Page.
     *
     * @return Response
     */
    public function createNew(OrderService $orderService)
    {
        abort_if(! userCan('order.create'), 403);

        try {
            $data = $orderService->create();

            return view('admin.order.create', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store A Order  .
     *
     * @return Response
     */
    public function store(OrderRequest $request, OrderService $orderService)
    {
        abort_if(! userCan('order.store'), 403);
        try {
            $transaction = $orderService->store($request);

            flashSuccess('Order Added!');

            return redirect()->route('order.user.plan.update', $transaction->id);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Edit the specified resource.
     *
     * @return Response
     */
    public function edit(Transaction $transaction, OrderService $orderService)
    {
        try {
            $data = $orderService->edit($transaction);

            return view('admin.order.edit', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource.
     *
     * @return Response
     */
    public function update(OrderRequest $request, Transaction $transaction, OrderService $orderService)
    {
        try {
            $orderService->update($request, $transaction);

            flashSuccess('Order Updated!');

            return redirect()->route('order.user.plan.update', $transaction->id);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Transaction $transaction)
    {
        abort_if(! userCan('order.view'), 403);
        try {
            $transaction->load('plan', 'customer');

            return view('admin.order.show', compact('transaction'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Download invoice as pdf or print.
     *
     * @return Response
     */
    public function downloadTransactionInvoice(Transaction $transaction)
    {
        try {
            $data['transaction'] = $transaction->load('plan', 'customer');

            $pdf = PDF::loadView('admin.order.invoice', $data)
                ->setPaper('a4', 'portrait')
                ->setOptions(['defaultFont' => 'sans-serif']);

            return $pdf->download('invoice_'.$transaction->order_id.'.pdf');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * update the specified user plan data.
     *
     * @return Response
     */
    public function updateUserPlan(Transaction $transaction, OrderService $orderService)
    {
        try {
            $data = $orderService->updatePlan($transaction);

            return view('admin.order.user_plan', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * update the specified user plan data.
     *
     * @return RedirectResponse
     */
    public function UserPlanUpdate(Request $request, User $user, OrderService $orderService)
    {
        try {
            $plan_status = $this->calculatePlanStatus($user->userPlan, $request->user_plan);
            $plan = $orderService->updatePlanData($request, $user);

            if (checkMailConfig()) {
                $user->notify(new PlanUpdateNotification($user, $plan, $plan_status));
            }

            flashSuccess('User Plan Data Updated!');

            return redirect()->route('order.index');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function calculatePlanStatus($user_plan, $new_plan)
    {
        try {
            $text = 'updated';
            $user_plan_get = Plan::where('id', $user_plan->current_plan_id)->first();
            if ($user_plan_get) {
                $new_plan_get = Plan::where('id', $new_plan)->first();
                if ($user_plan_get->price > $new_plan_get->price) {
                    $text = 'upgraded';
                } else {
                    $text = 'downgraded';
                }
            }

            return $text;
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}

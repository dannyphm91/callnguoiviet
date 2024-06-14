<?php

namespace Modules\Customer\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserDocumentVerification;
use App\Notifications\DocumentVerificationStatusNotification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Modules\Ad\Entities\Ad;
use Modules\Customer\Http\Requests\CustomerCreateFormRequest;
use Modules\Customer\Http\Requests\CustomerUpdateFormRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return Renderable
     */
    public function index()
    {
        if (! userCan('customer.view')) {
            return abort(403);
        }
        try {
            $query = User::query();

            // keyword search
            if (request()->has('keyword') && request()->keyword != null) {
                $keyword = request('keyword');
                $query
                    ->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('username', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%");
            }

            // filtering
            if (request()->has('filter_by') && request()->filter_by != null) {
                switch (request()->filter_by) {
                    case 'verified':
                        $query->whereNotNull('email_verified_at');
                        break;
                    case 'unverified':
                        $query->whereNull('email_verified_at');
                        break;
                }
            }

            $query->withCount('transactions')->with(['userPlan', 'document_verified']);
            $customers = $query->paginate(10)->withQueryString();

            $verification_requests = UserDocumentVerification::approved()->count();

            return view('customer::index', compact('customers', 'verification_requests'));
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
        return view('customer::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(CustomerCreateFormRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $url = $request->image->move('uploads/customer', $request->image->hashName());
                $data['image'] = $url;
            }

            User::create($data);

            flashSuccess('Customer Created Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show(User $customer)
    {
        try {
            $ads = Ad::where('user_id', $customer->id)
                ->with('category')
                ->latest()
                ->paginate(10);
            $transactions = Transaction::where('user_id', $customer->id)
                ->with('plan:id,label')
                ->latest()
                ->take(10)
                ->get();

            return view('customer::show', compact('customer', 'ads', 'transactions'));
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
    public function edit(User $customer)
    {
        return view('customer::edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Customer  $customer
     * @return Renderable
     */
    public function update(CustomerUpdateFormRequest $request, User $customer)
    {
        try {
            $data = $request->all();
            if ($data['password'] != null) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $url = $request->image->move('uploads/customer', $request->image->hashName());
                $data['image'] = $url;
            }

            $customer->update($data);

            flashSuccess('Customer Updated Successfully');

            return redirect()->route('module.customer.index');
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
    public function destroy(User $customer)
    {
        try {
            if ($customer) {
                $customer->delete();
            }

            flashSuccess('Customer Deleted Successfully');

            return back();
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
    public function emailVerify(Request $request)
    {
        try {
            $customer = User::where('username', $request->username)->firstOrFail();

            if ($customer->email_verified_at) {
                $customer->update(['email_verified_at' => null]);
            } else {
                $customer->update(['email_verified_at' => now()]);
            }

            flashSuccess('Email Verified Successfully');
            if ($customer->email_verified_at) {
                return response()->json(['message' => 'Email Verified Successfully']);
            } else {
                return response()->json(['message' => 'Email Unverified Successfully']);
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function ads(User $customer)
    {
        try {
            $ads = Ad::where('user_id', $customer->id)
                ->with('category', 'subcategory', 'brand:id,name,slug')
                ->latest()
                ->paginate(10);

            return view('customer::ads', compact('ads', 'customer'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Customer Account Verification Request
     *
     * @return Renderable
     */
    public function verificationRequest()
    {
        if (! userCan('verification-request.index')) {
            return abort(403);
        }
        try {
            $query = UserDocumentVerification::query()->with('user');

            // keyword search
            if (request()->has('keyword') && request()->keyword != null) {
                $keyword = request('keyword');
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('username', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%");
                });
            }

            // type search
            if (request()->has('data') && request()->data != null) {
                $type = request('data');
                if ($type == 'approved') {
                    $query->where('status', 'approved');
                }
                if ($type == 'pending') {
                    $query->where('status', 'pending');
                }
                if ($type == 'rejected') {
                    $query->where('status', 'rejected');
                }
            } else {
                $query->where('status', '!=', 'approved');
            }

            $requests = $query->paginate(10)->withQueryString();

            return view('customer::verification-request', compact('requests'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Customer Account Verification Request Details
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function verificationRequestShow(UserDocumentVerification $request)
    {
        if (! userCan('verification-request.show')) {
            return abort(403);
        }
        try {
            $request->load('user');

            return view('customer::verification-details', compact('request'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Customer Account Verification Request Download
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function verificationRequestDownload(Request $requ, UserDocumentVerification $request)
    {
        if ($requ->doc_type == 'passport') {
            $path = $request->password_url;
        }

        try {
            return Response::download($path);
        } catch (\Exception $e) {
            flashError($e->getMessage());

            return back();
        }
    }

    /**
     * Customer Account Verification Request Status Change
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function verificationRequestStatus(Request $requ, UserDocumentVerification $request)
    {
        if (! userCan('verification-request.status')) {
            return abort(403);
        }
        try {
            $request->update([
                'status' => $requ->status,
                'rejected_reason' => $requ->rejected_reason ?? null,
            ]);
            flashSuccess('Document Status Updated .');
            // mail to admin
            if (checkMailConfig()) {
                Notification::send($request->user, new DocumentVerificationStatusNotification($request->user, $request));
            }

            return redirect()->route('module.customer.verification.request');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Customer Account Verification Request Destroy
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function verificationRequestDestroy(UserDocumentVerification $request)
    {
        if (! userCan('verification-request.destroy')) {
            return abort(403);
        }
        try {
            $passport = $request->password_photo_url;
            if ($passport) {
                unlink(storage_path('app/'.$passport));
            }

            $request->delete();

            flashSuccess('Document Request Deleted .');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}

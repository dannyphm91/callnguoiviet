<?php

namespace Modules\Newsletter\Http\Controllers;

// use App\Mail\NewsletterMail;

use App\Exports\EmailExport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Newsletter\Entities\Email;
use PDF;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        if (! enableModule('newsletter')) {
            abort(404);
        }
        $request->validate([
            'email' => 'required|email|unique:emails,email',
        ]);
        try {
            Email::create(['email' => $request->email]);

            return 'Your subscription added successfully!';
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        if (! userCan('newsletter.view')) {
            abort(403);
        }
        try {
            $data['emails'] = Email::latest()->paginate(20);

            return view('newsletter::index', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function destroy(Email $email)
    {
        if (! userCan('newsletter.delete')) {
            abort(403);
        }
        try {
            $deleted = $email->delete();
            $deleted ? flashSuccess('Email Deleted Successfully') : flashError();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Email list export
     *
     * @param Request
     */
    public function download(Request $request)
    {
        try {
            // return $request;
            // if type csv
            if ($request->type == 'excel') {
                $amount = $request->amount ? $request->amount : 5;
                $from = $request->from;

                return Excel::download(new EmailExport($amount, $from), 'emails-list.xlsx');

                // if type excel
            } elseif ($request->type == 'csv') {
                $amount = $request->amount ? $request->amount : 5;
                $from = $request->from;

                return Excel::download(new EmailExport($amount, $from), 'emails-list.csv');
            }
            // if type pdf
            else {
                $amount = $request->amount ? $request->amount : 5;

                if ($request->from == 'latest') {
                    $emails = Email::latest()
                        ->select('id', 'email')
                        ->limit($amount)
                        ->get();
                } else {
                    $emails = Email::oldest()
                        ->select('id', 'email')
                        ->limit($amount)
                        ->get();
                }

                $pdf = PDF::loadView('newsletter::export-pdf', compact('emails'));

                return $pdf->download('email-list.pdf');
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}

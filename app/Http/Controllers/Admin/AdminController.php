<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSearch;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Entities\Ad;
use Modules\Blog\Entities\Post;
use Modules\Plan\Entities\Plan;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            return view('admin.home');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function dashboard()
    {
        try {
            session(['layout_mode' => 'left_nav']);

            $customers = User::all();
            $ads = Ad::all();

            $data['total_earning'] = Transaction::where('payment_status', 'paid')->sum('amount');
            $data['customer'] = $customers->count();
            $data['verified_customers'] = $customers->whereNotNull('email_verified_at')->count();
            $data['adcount'] = $ads->count();
            $data['adcountActive'] = $ads->where('status', 'active')->count();
            $data['adcountPending'] = $ads->where('status', 'pending')->count();
            $data['adcountExpired'] = $ads->where('status', 'sold')->count();
            $data['adcountFeatured'] = $ads->where('featured', 1)->count();
            $countryCount = DB::table('ads')
                ->select('country', DB::raw('count(*) as total'))
                ->groupBy('country')
                ->get();
            $data['totalCountry'] = $countryCount->count();
            $data['blogpostCount'] = Post::count();
            $data['total_plan'] = Plan::count();

            $data['latestAds'] = Ad::select(['id', 'slug', 'price', 'status', 'title'])
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            $data['latestusers'] = User::select(['id', 'name', 'email', 'created_at', 'username'])
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            $data['latestTransactionUsers'] = Transaction::with(['customer:id,name,email,username', 'plan:id,label,price'])
                ->latest()
                ->limit(10)
                ->get();

            $data['topLocations'] = DB::table('ads')
                ->select('country', DB::raw('count(*) as total'))
                ->orderBy('total', 'desc')
                ->groupBy('country')
                ->limit(10)
                ->get();

            $months = Transaction::select(\DB::raw('MIN(created_at) AS created_at'), \DB::raw('sum(amount) as `amount`'), \DB::raw("DATE_FORMAT(created_at,'%M') as month"))
                ->where('created_at', '>', \Carbon\Carbon::now()->startOfYear())
                ->orderBy('created_at')
                ->groupBy('month')
                ->get();

            $data['earnings'] = $this->formatEarnings($months);

            return view('admin.index', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    private function formatEarnings(object $data)
    {
        try {
            $amountArray = [];
            $monthArray = [];

            foreach ($data as $value) {
                array_push($amountArray, $value->amount);
                array_push($monthArray, $value->month);
            }

            return ['amount' => $amountArray, 'months' => $monthArray];
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function search(Request $request)
    {
        try {
            $pages = AdminSearch::where('page_title', 'LIKE', "%$request->data%")
                ->limit(10)
                ->get();

            return response()->json(['pages' => $pages]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}

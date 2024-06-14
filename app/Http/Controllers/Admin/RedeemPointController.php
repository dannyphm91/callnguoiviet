<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RedeemPoint;
use Illuminate\Http\Request;

class RedeemPointController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $redeemPoints = RedeemPoint::latest()->paginate(10);

            return view('admin.redeem-point.index', compact('redeemPoints'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.redeem-point.create');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'points' => 'required|numeric',
            'redeem_balance' => 'required|numeric',
        ]);

        try {
            RedeemPoint::create([
                'points' => $request->points,
                'redeem_balance' => (float) $request->redeem_balance,
            ]);

            flashSuccess('Redeem Points Added Successfully');

            return redirect()->route('redeem-points.index');

        } catch (\Throwable $th) {
            flashError('An error occured:'.$th->getMessage());

            return back();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $redeemPoint = RedeemPoint::find($id);

            return view('admin.redeem-point.edit', compact('redeemPoint'));

        } catch (\Exception $e) {
            flashError();

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'points' => 'required|numeric',
            'redeem_balance' => 'required|numeric',
        ]);

        try {
            $redeemPoint = RedeemPoint::findOrFail($id);

            $redeemPoint->update([
                'points' => $request->points,
                'redeem_balance' => (float) $request->redeem_balance,
            ]);

            flashSuccess('Redeem Points Updated Successfully');

            return redirect()->route('redeem-points.index');

        } catch (\Throwable $th) {
            flashError('An error occurred: '.$th->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $redeemPoint = RedeemPoint::findOrFail($id);
            $redeemPoint->delete();

            flashSuccess('Redeem Points  Deleted Successfully');

            return redirect(route('redeem-points.index'));

        } catch (\Throwable $th) {
            flashError('Error Occurred:'.$th->getMessage());

            return back();
        }
    }
}

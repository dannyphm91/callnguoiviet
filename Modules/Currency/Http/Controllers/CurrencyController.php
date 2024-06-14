<?php

namespace Modules\Currency\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Currency\Entities\Currency;
use Modules\Currency\Http\Requests\CurrencyCreateFormRequest;
use Modules\Currency\Http\Requests\CurrencyUpdateFormRequest;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        try {
            $currencies = Currency::paginate(15);

            return view('currency::index', compact('currencies'));
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
        return view('currency::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(CurrencyCreateFormRequest $request)
    {
        try {
            Currency::create([
                'name' => $request->name,
                'code' => $request->code,
                'symbol' => $request->symbol,
                'rate' => $request->rate,
                'symbol_position' => $request->symbol_position ? 'left' : 'right',
            ]);

            flashSuccess('Currency Created Successfully');

            return redirect()->route('module.currency.index');
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
    public function show($id)
    {
        return view('currency::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Renderable
     */
    public function edit(Currency $currency)
    {
        return view('currency::edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Renderable
     */
    public function update(CurrencyUpdateFormRequest $request, Currency $currency)
    {
        try {
            $currency->update([
                'name' => $request->name,
                'code' => $request->code,
                'symbol' => $request->symbol,
                'rate' => $request->rate,
                'symbol_position' => $request->symbol_position ? 'left' : 'right',
            ]);

            if ($currency->code == config('templatecookie.currency')) {
                envReplace('APP_CURRENCY_SYMBOL_POSITION', $currency->symbol_position);
            }

            flashSuccess('Currency Updated Successfully');

            return redirect()->route('module.currency.index');
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
    public function destroy(Currency $currency)
    {
        try {
            if ($currency->code == config('templatecookie.currency')) {
                $currencyDefault = Currency::where('code', 'USD')->first();
                if ($currencyDefault) {
                    envReplace('APP_CURRENCY', $currencyDefault->code);
                    envReplace('APP_CURRENCY_SYMBOL', $currencyDefault->symbol);
                    envReplace('APP_CURRENCY_SYMBOL_POSITION', $currencyDefault->symbol_position);
                }
            }

            $currency->delete();

            flashSuccess('Currency Deleted Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function defaultCurrency(Request $request)
    {
        try {
            $currency = Currency::findOrFail($request->currency);

            envReplace('APP_CURRENCY', $currency->code);
            envReplace('APP_CURRENCY_SYMBOL', $currency->symbol);
            envReplace('APP_CURRENCY_SYMBOL_POSITION', $currency->symbol_position);

            flashSuccess('Currency Changed Successfully');

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function changeCurrency($code)
    {
        try {
            $currency = Currency::where('code', $code)->first();
            session(['current_currency' => $currency]);
            currencyRateStore();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}

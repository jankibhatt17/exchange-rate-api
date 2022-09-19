<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ExchangeRate;
use App\Models\CurrencyRate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CurrencyExchangeRequest;

class CurrencyController extends Controller
{
     /**
     * The user implementation
     *
     * @var User
     */
    protected $user;
    /**
     * Creates a new controller instance.
     *
     * @param   User         $user
     *
     * @return  void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function index()
    {
       return redirect()->view('currency.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = Http::get('https://api.exchangerate.host/latest');

        $res = $response->getBody()->getContents();
    
        $currency_rates = null;
        if (false !== $res) {
            try {
                $response = json_decode($res);
                if($response->success === true) {
                    $currency_rates = $response;
                }
            } catch(Exception $e) {
                dd($e);
            }
        }  
        
        return view('currency.create', compact('currency_rates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyExchangeRequest $request, ExchangeRate $exchangeRate) 
    {
        $validated = $request->validated(); 
        // dd($validated);
        $user = auth()->user();

        $exchange_rates = $this->getExchangeRates($validated['start_date'], $validated['end_date'], $validated['base']);
     
        if (!empty($exchange_rates->items)) {
            return view('currency.index', compact('exchange_rates'));
        }

        $response = Http::get('https://api.exchangerate.host/timeseries', [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'base' => $validated['base']
        ]);
        $res = $response->getBody()->getContents();
        
        $currency_rates = null;
        if(false == $res) {
            return redirect()->route('currency.index');
        }

        try {
            $response = json_decode($res);
            if($response->success === true) {
                $currency_rates = $response;
            }

            $exchangeRate = new ExchangeRate();
            $exchangeRate->start_date = $validated['start_date'];
            $exchangeRate->end_date = $validated['end_date'];
            $exchangeRate->base = $validated['base'];

            $exchangeRate->save();

            foreach($currency_rates->rates as $key => $value) {
                foreach($value as $k => $v) {
                    $currencyRate = new CurrencyRate();
                    $currencyRate->user_id = Auth::id();
                    $currencyRate->exchange_rate_id = $exchangeRate->id;
                    $currencyRate->date = $key;
                    $currencyRate->currency = $k;
                    $currencyRate->rate = $v;
            
                    $currencyRate->save();
                }
            }

        $exchange_rates = $this->getExchangeRates($validated['start_date'], $validated['end_date'], $validated['base']);
        return view('currency.index', compact('exchange_rates'));

        } catch(Exception $e) {
            dd($e);
        } 
        
    }

    private function getExchangeRates($start_date, $end_date, $base)
    {
       $exchange_rates = ExchangeRate::with(['currencyRates', 'user'])
                        ->where('start_date', $start_date)
                        ->where('end_date', $end_date)
                        ->where('base', $base)
                        ->paginate(10);

        return $exchange_rates;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExchangeRate $exchangeRate)
    {
        $exchangeRate = $exchangeRate->where('id', '=', $exchangeRate->id)->get();
        if ($exchangeRate->count()) {
            ExchangeRate::where('id', '=', $exchangeRate->id)->delete();
            CurrencyRate::where('id', '=', $exchangeRate->exchange_rate_id)->delete();
        }
          
    }
}

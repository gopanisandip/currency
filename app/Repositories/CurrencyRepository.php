<?php

namespace App\Repositories;

use App\Models\Curruncy;
use Illuminate\Http\Request;
use function Illuminate\Support\Facades\Date;
use Carbon\Carbon;

class CurrencyRepository
{


    public static function getCurrency($request)
    {

        $page = 1;
        $page_length = 10;

        if(isset($request['page'])){
            $page = $request['page'];
        }

        if(isset($request['page_size'])){
            $page_length = $request['page_size'];
        }

        $request['type'] = "list";

        if(isset($request['page']) || isset($request['page_size'])){

        $currency = Curruncy::paginate($page_length)->appends(['page' => $page]);
            return $currency;
        }
        $currency = Curruncy::all();
        return $currency;

    }
    public static function getHistory($request)



    {

        $page = 1;
        $page_length = 10;

        if(isset($request['page'])){
            $page = $request['page'];
        }

        if(isset($request['page_size'])){
            $page_length = $request['page_size'];
        }

        $request['type'] = "history";

        $date_to = Carbon::now()->toDateString();
        $date_from = Carbon::now()->startOfMonth()->toDateString();


//        dd($request, $date_from);
        if(isset($request['date_from'])){
            $date_from = $request['date_from'];
        }
        if(isset($request['date_to'])){
            $date_to = $request['date_to'];
        }


        $currency = Curruncy::where('curr_id', $request['id']);
        if(isset($request['base_currency_id'])){
            $currency = Curruncy::where('curr_id', $request['base_currency_id']);

            if(isset($request['date'])){
                $currency = $currency->where('date', $request['date']);
            }
//dd(Curruncy::where('curr_id', $request['base_currency_id'])->max('Value'));
            $request['maximum'] = Curruncy::where('curr_id', $request['base_currency_id'])->max('Value');
//            dd($request);
//            $request['min'] = $currency->min('Value');
        }
        if(isset($request['date_from']) || isset($request['date_to'])){
            $currency = $currency->whereBetween('date', [$date_from, $date_to]);
        }
        if(isset($request['page']) || isset($request['page_size'])){
//dd($request['page_size']);
            $currency = $currency->paginate($page_length)->appends(['page' => $page]);
            return $currency;
        }else{

            $currency = $currency->get();
        }


        return $currency;
    }
}

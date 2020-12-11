<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\History;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\CurrencyResourceCollection;

class CurrencyController extends Controller
{
    public function index(Request $request){

       $currency = CurrencyRepository::getCurrency($request->all());
        return new CurrencyResourceCollection($currency);
    }
    public function history(History $request){

       $currency = CurrencyRepository::getHistory($request->all());
        return new CurrencyResourceCollection($currency);
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Curruncy;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CurrencyResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        dd(parent::toArray($request));
        return parent::toArray($request);
    }
    public function with($request){
        $data = [];
        if(isset($request['base_currency_id'])){
            $currency = Curruncy::where('curr_id', $request['base_currency_id']);

            $data['maximum'] = $currency->max('Value');
            $data['min'] = $currency->min('Value');
            $data['sum'] = $currency->sum('Value');
            $data['count'] = $currency->count();
            $avg = ($data['count'] * 100) / ($data['sum'] * 100);
            $data['avg'] =  number_format($avg, 2);
        }
        return [
            'avg' => $data,
        ];

    }
}

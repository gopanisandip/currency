<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class CurrencyResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */


    public function toArray($request)
    {
//        dd($request);

        if($request['type'] == "list"){

            return [
                'currency_id' => $this->curr_id,
                'rate' => number_format($this->Value),
            ];
        }
        return [


            'currency_id' => $this->curr_id,
            'rate' => number_format($this->Value),
            'name' => $this->CurrName,
            'charcode' => $this->CharCode,
            'numcode' => $this->NumCode,
            'nominal' => $this->Nominal,
            'date' => $this->date,
            'created_at' => $this->date,
        ];
    }

}

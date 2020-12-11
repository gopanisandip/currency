<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\BaseRequest;

class History extends BaseRequest
{

    public function authorize()
    {

   return true;
    }

    public function rules()
    {
        $data = $this->all();

        return [
            'id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Currency id is required'
        ];
    }
}

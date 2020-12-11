<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class WebBaseRequest extends FormRequest {

    protected function failedValidation(Validator $validator) {

    }

    protected function failedAuthorization() {
        throw new HttpResponseException(redirect('/'));
    }

}

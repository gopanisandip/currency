<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Access\AuthorizationException;

class BaseRequest extends FormRequest {

    protected $routes_with_siteid = [
        'playlists.store',
        'video-articles.store',
        'ads.store',
        'videos.store',
    ];

    public function expectsJson() {
        return true;
    }

    public function wantsJson() {
        return true;
    }

    protected function failedValidation(Validator $validator) {

        $response = [
            'status' => 'VALIDATION_ERROR',
            'code' => 422,
            'message' => 'Please check errors'
        ];

        $errors = $validator->errors()->messages();


        foreach ($errors as $field => $error) {

            $match = get_string_bettween_string('.','.', $field);


            if(isset($match[0]) && isset($match[1])){
                $field = str_replace($match[0], '['.$match[1] .'][', $field);
            }

            preg_match('/.[0-9]+$/', $field, $m);

            if(!empty($m)){
                $field = str_replace($m[0], '[]', $field);
            }

            if(isset($match[0]) && isset($match[1])){
                $field .= ']';
            }

            $response['errors'][$field] = $error[0];

        }

        if (!empty($response['errors']['unsupported_request_data'])) {

            unset($response['errors']);
            $response['message'] = 'Unexpected parameters found!';
        }

     /*   $response['related-links'] = [
           // $this->getRelatedLink($this->route()),
          //  config('env.DEVELOPERS_DOMAIN') . '/doc/api/errors'
        ];*/

        throw new HttpResponseException(response()->json($response, 422));
    }

    protected function failedAuthorization() {
        $route = $this->route()->action;
//      dd( $this->routes_with_siteid);
        if (in_array($route['as'], $this->routes_with_siteid)) {

            if (!array_key_exists('site_id', $this->post())) {
                $response = [
                    'status' => 'VALIDATION_ERROR',
                    'code' => 422,
                    'message' => 'Site id is required'
                ];

                $response['related-links'] = [
                   // $this->getRelatedLink($this->route()),
                   // config('env.DEVELOPERS_DOMAIN') . '/doc/api/errors'
                ];

                throw new HttpResponseException(response()->json($response, 401));
            }
        }


        $response = [
            'status' => 'AUTHORIZATION_ERROR',
            'code' => 401,
            'message' => 'You are not authorized for this action!'
        ];

        $response['related-links'] = [
            //$this->getRelatedLink($this->route()),
           // config('env.DEVELOPERS_DOMAIN') . '/doc/api/errors'
        ];

        throw new HttpResponseException(response()->json($response, 401));
    }

    protected function getRelatedLink($route) {

        //dd($route);

       // $action = $route->action;

        $url = '';

        if ($route['as'] === 'video-articles.store') {
            $url = 'video-articles/create';
        }

        return config('env.DEVELOPERS_DOMAIN') . '/doc/api/' . $url;
    }

}

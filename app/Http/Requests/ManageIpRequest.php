<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ManageIpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ip' => 'required|max:39|ip|unique:ip_address,ip,' . $this->id,
            'label' => 'required|max:255',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    protected function failedValidation(Validator $validator)
    {
        $return_response_data = responseData(false, Response::HTTP_BAD_REQUEST, 'Request param validation error.', $validator->errors());
        errorLog(
            __METHOD__,
            Response::$statusTexts[Response::HTTP_BAD_REQUEST],
            $return_response_data
        );
        throw new HttpResponseException(
            response()->json($return_response_data, Response::HTTP_BAD_REQUEST)
        );
    }
}

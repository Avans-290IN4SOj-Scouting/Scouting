<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;

class StockUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Update this if you need to add authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        foreach ($this->all() as $key => $value) {
            if (Str::startsWith($key, 'size-')) {
                $rules[$key] = 'integer|between:0,100';
            }
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            '*.integer' => __('manage-stocks/stocks.invalid_type'),
            '*.between' => __('manage-stocks/stocks.invalid_amount'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        $firstError = array_shift($errors)[0];

        throw new HttpResponseException(
            back()->withInput($this->input())->with([
                'toast-type' => 'error',
                'toast-message' => $firstError,
            ])
        );
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StockUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Update this if you need to add authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
    public function messages()
    {
        return [
            '*.integer' => __('manage-stocks/stocks.invalid_type'),
            '*.between' => __('manage-stocks/stocks.invalid_amount'),
        ];
    }
}

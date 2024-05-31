<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'products-category-multiselect' => 'required|array',
            'products-group-multiselect' => 'required|array',
            'price_input' => 'required|array',
            'price_input.*' => 'required|numeric|max:1000|min:0',
            'af-submit-app-upload-images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('manage-products/requests.name.required'),
            'name.string' => __('manage-products/requests.name.string'),
            'products-category-multiselect.required' => __('manage-products/requests.category.required'),
            'products-category-multiselect.array' => __('manage-products/requests.category.array'),
            'af-submit-app-upload-images.required' => __('manage-products/requests.image.required'),
            'af-submit-app-upload-images.file' => __('manage-products/requests.image.file'),
            'af-submit-app-upload-images.image' => __('manage-products/requests.image.image'),
            'af-submit-app-upload-images.mimes' => __('manage-products/requests.image.mimes'),
            'af-submit-app-upload-images.max' => __('manage-products/requests.image.max'),
            'products-group-multiselect.required' => __('manage-products/requests.group.required'),
            'products-group-multiselect.array' => __('manage-products/requests.group.array'),
            'price_input.required' => __('manage-products/requests.price.required'),
            'price_input.*.required' => __('manage-products/requests.price.required'),
            'price_input.*.numeric' => __('manage-products/requests.price.numeric'),
            'price_input.*.max' => __('manage-products/requests.price.max'),
            'price_input.*.min' => __('manage-products/requests.price.min'),
        ];
    }
}

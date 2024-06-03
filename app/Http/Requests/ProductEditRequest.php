<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductEditRequest extends FormRequest
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
            'products-category-multiselect' => 'required|array',
            'products-group-multiselect' => 'required|array',
            'priceForSize' => ['nullable', 'array', function ($attribute, $value, $fail) {
                $priceForSize = $this->input('priceForSize') ?? [];
                $custom_prices = $this->input('custom_prices') ?? [];
                if (is_array($priceForSize) && is_array($custom_prices)) {
                    foreach ($priceForSize as $price) {
                        if (!is_null($price)) {
                            return;
                        }
                    }
                    foreach ($custom_prices as $price) {
                        if (!is_null($price)) {
                            return;
                        }
                    }
                }
                $fail(__('manage-products/requests.price.required'));
            },],
            'priceForSize.*' => 'nullable|numeric|max:1000|min:0',
            'custom_prices' =>  ['nullable', 'array', function ($attribute, $value, $fail) {
        $priceForSize = $this->input('priceForSize') ?? [];
        $custom_prices = $this->input('custom_prices');
        if (is_array($priceForSize) && is_array($custom_prices)) {
            foreach ($priceForSize as $price) {
                if (!is_null($price)) {
                    return;
                }

            }
            foreach ($custom_prices as $price) {
                if (!is_null($price)) {
                    return;
                }
            }
        }
        $fail(__('manage-products/requests.price.required'));
    },],
            'custom_prices.*' => 'nullable|numeric|max:1000|min:0',
            'custom_sizes' => ['nullable', 'array', function ($attribute, $value, $fail) {
                $custom_sizes = $this->input('custom_sizes');
                $custom_prices = $this->input('custom_prices') ?? [];
                for($i = 0; $i < count($custom_sizes); $i += 1) {
                    if (is_null($custom_sizes[$i]) && !is_null($custom_prices[$i])) {
                        $fail(__('manage-products/requests.size.required'));
                        return;
                    }
                    if(!is_null($custom_sizes[$i]) && is_null($custom_prices[$i])) {
                        $fail(__('manage-products/requests.price.required'));
                        return;
                    }
                }
            }],
            'custom_sizes.*' => 'nullable|string',
            'af-submit-app-upload-images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
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
            'priceForSize.array' => __('manage-products/requests.price.array'),
            'priceForSize.*.numeric' => __('manage-products/requests.price.numeric'),
            'priceForSize.*.max' => __('manage-products/requests.price.max'),
            'priceForSize.*.min' => __('manage-products/requests.price.min'),
            'custom_prices.*.numeric' => __('manage-products/requests.price.numeric'),
            'custom_prices.*.max' => __('manage-products/requests.price.max'),
            'custom_prices.*.min' => __('manage-products/requests.price.min'),
            'custom_sizes.*.string' => __('manage-products/requests.size.string'),
        ];
    }
}

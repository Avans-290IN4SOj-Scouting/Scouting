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
            'name' => 'required|string',
            'category' => 'required|string',
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
                $fail('Vul minimaal 1 prijs in voor de maat.');
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
        $fail('Vul minimaal 1 prijs in voor de maat.');
    },],
            'custom_prices.*' => 'nullable|numeric|max:1000|min:0',
            'custom_sizes' => ['nullable', 'array', function ($attribute, $value, $fail) {
                $custom_sizes = $this->input('custom_sizes');
                $custom_prices = $this->input('custom_prices') ?? [];
                for($i = 0; $i < count($custom_sizes); $i += 1) {
                    if (is_null($custom_sizes[$i]) && !is_null($custom_prices[$i])) {
                        $fail('Vul een maat in voor de prijs.');
                        return;
                    }
                    if(!is_null($custom_sizes[$i]) && is_null($custom_prices[$i])) {
                        $fail('Vul een prijs in voor de maat.');
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
            'name.required' => 'Het naam veld moet ingevuld worden.',
            'name.string' => 'Het naam veld moet een tekst zijn.',
            'category.required' => 'Het Kleur categorie veld moet ingevuld worden.',
            'category.string' => 'Het Kleur categorie veld moet een tekst zijn.',
            'af-submit-app-upload-images.required' => 'Voeg een afbeelding toe.',
            'af-submit-app-upload-images.file' => 'Je probeert iets te uploaden dat geen bestand is.',
            'af-submit-app-upload-images.image' => 'Het geüploade bestand moet een afbeelding zijn.',
            'af-submit-app-upload-images.mimes' => 'Het geüploade bestand moet een van de volgende formaten hebben: jpeg, png, jpg, gif.',
            'af-submit-app-upload-images.max' => 'Het geüploade bestand mag maximaal 2048 kilobytes zijn.',
            'products-group-multiselect.required' => 'Geef aan bij welke groepen dit product hoort',
            'products-group-multiselect.array' => 'Het groepen veld heeft een array object nodig.',
            'priceForSize.array' => 'Het prijs per maat veld moet een array zijn.',
            'priceForSize.*.numeric' => 'Elke prijs moet numeriek zijn.',
            'priceForSize.*.max' => 'Elke prijs moet maximaal 1000 zijn.',
            'priceForSize.*.min' => 'Elke prijs moet minimaal 0 zijn.',
            'custom_prices.*.numeric' => 'Elke prijs moet numeriek zijn.',
            'custom_prices.*.max' => 'Elke prijs moet maximaal 1000 zijn.',
            'custom_prices.*.min' => 'Elke prijs moet minimaal 0 zijn.',
            'custom_sizes.*.string' => 'Het aangepaste maten veld moet een tekst zijn.',
        ];
    }
}

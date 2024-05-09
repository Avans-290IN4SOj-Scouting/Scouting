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

                $defaultPriceExists = false;
                $customSizeWithPriceExists = false;

                // Check if a default price or a custom size with price exists
                foreach ($priceForSize as $size => $price) {
                    if ($size === 'Default' && $price !== null) {
                        $defaultPriceExists = true;
                    } elseif ($size !== 'Default' && $price !== null) {
                        $customSizeWithPriceExists = true;
                    }
                }

                // If a custom size with price exists, prevent adding the default size with a price
                if ($customSizeWithPriceExists && $defaultPriceExists) {
                    $fail("You can't add a default size with a price when a custom size with a price already exists.");
                    return;
                }

                // If a default price exists, prevent adding other sizes with prices
                if ($defaultPriceExists) {
                    foreach ($priceForSize as $size => $price) {
                        if ($size !== 'Default' && $price !== null) {
                            $fail("You can't add another size with a price when a default size with a price already exists.");
                            return;
                        }
                    }
                }

                // Check if at least one price is provided for either default or custom sizes
                if (empty(array_filter($priceForSize)) && empty(array_filter($custom_prices))) {
                    $fail('Vul minimaal 1 prijs in voor de maat.');
                    return;
                }
            }],
            'priceForSize.*' => 'nullable|numeric',
            'custom_prices' => 'nullable|array',
            'custom_prices.*' => 'nullable|numeric',
            'custom_sizes' => ['nullable', 'array', function ($attribute, $value, $fail) {
                $custom_sizes = $this->input('custom_sizes');
                $custom_prices = $this->input('custom_prices');
                for($i = 0; $i < count($custom_sizes); $i += 1) {
                    if (is_null($custom_sizes[$i]) && !is_null($custom_prices[$i])) {
                        $fail('Vul een maat in voor de prijs.');
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
            'priceForSize.*.numeric' => 'Het prijs per maat veld moet numeriek zijn.',
            'custom_prices.*.numeric' => 'Het aangepaste prijzen veld moet numeriek zijn.',
            'custom_sizes.*.string' => 'Het aangepaste maten veld moet een tekst zijn.',
        ];
    }
}

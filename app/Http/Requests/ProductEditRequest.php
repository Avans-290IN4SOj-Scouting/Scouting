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
        $product = $this->route('id') ? Product::find($this->route('id')) : null;
        return [
            'name' => 'required|string|unique:products,name,' . $product->id . ',id',
            'category' => 'required|string',
            'products-group-multiselect' => 'required|array',
            'priceForSize' => 'required|array|has_at_least_one_value',
            'priceForSize.*' => 'nullable|numeric',
            'custom_prices' => 'nullable|array',
            'custom_prices.*' => 'nullable|numeric',
            'custom_sizes' => 'nullable|array',
            'custom_sizes.*' => 'nullable|string',
            'af-submit-app-upload-images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Het naam veld moet ingevuld worden.',
            'name.string' => 'Het naam veld moet een tekst zijn.',
            'name.unique' => 'Een product met deze naam bestaat al.',
            'category.required' => 'Het Kleur categorie veld moet ingevuld worden.',
            'category.string' => 'Het Kleur categorie veld moet een tekst zijn.',
            'af-submit-app-upload-images.required' => 'Voeg een afbeelding toe.',
            'af-submit-app-upload-images.file' => 'Je probeert iets te uploaden dat geen bestand is.',
            'af-submit-app-upload-images.image' => 'Het geüploade bestand moet een afbeelding zijn.',
            'af-submit-app-upload-images.mimes' => 'Het geüploade bestand moet een van de volgende formaten hebben: jpeg, png, jpg, gif.',
            'af-submit-app-upload-images.max' => 'Het geüploade bestand mag maximaal 2048 kilobytes zijn.',
            'products-group-multiselect.required' => 'Geef aan bij welke groepen dit product hoort',
            'products-group-multiselect.array' => 'Het groepen veld heeft een array object nodig.',
            'priceForSize.required' => 'Vul minimaal 1 prijs in voor de maat.',
            'priceForSize.has_at_least_one_value' => 'Vul minimaal 1 prijs in voor de maat.',
            'priceForSize.array' => 'Het prijs per maat veld moet een array zijn.',
            'priceForSize.*.numeric' => 'Het prijs per maat veld moet numeriek zijn.',
            'custom_prices.*.numeric' => 'Het aangepaste prijzen veld moet numeriek zijn.',
            'custom_sizes.*.string' => 'Het aangepaste maten veld moet een tekst zijn.',
        ];
    }
}

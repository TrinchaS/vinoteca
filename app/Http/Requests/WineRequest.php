<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $imageRules = 'sometimes | image | mimes:jpeg,jpg,png | max:2048';
        if ($this->isMethod('post')){
            $imageRules = 'required | image | mimes:jpeg,jpg,png | max:2048';
        }
        return [
            'name' => ['required','string','max:255', Rule::unique('wines','name')->ignore($this->route('wine'))],
            'description' => ['required','string','max:2000'],
            'category_id' => ['required','exists:categories,id'],
            'year' => ['required','integer','min:'.now()->subYear(100)->year,'max:'.now()->year],
            'price' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'image' => $imageRules
        ];
    }

    public function messages():array{
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto.',
            'name.max' => 'El nombre no puede exceder los :max caracteres.',
            'name.unique' => 'El vino ya existe.',
            'description.required' => 'La descripción es requerida.',
            'description.string' => 'La descripción debe ser un texto.',
            'description.max' => 'La descripción no debe exceder los :max caracteres.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'year.required' => 'El año es obligatorio.',
            'year.integer' => 'El año debe ser un número entero',
            'year.min' => 'El año no puede ser menor a :min.',
            'year.max' => 'El año no puede ser superior a :max.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio no puede ser negativo.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un numero entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'image.required' => 'La imagen es requerida.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg.',
            'image.max' => 'La imagen no debe exceder los :max kilobytes.',
        ];
    }
}

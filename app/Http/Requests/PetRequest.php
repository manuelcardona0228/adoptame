<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:100',
            'photo' => 'image|mimes:*|size:1024',
            'species_id' => 'required',
            'breed_id' => 'required',
            'institution_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es requerido.',
            'name.min' => 'El nombre debe tener como minimo 3 caracteres.',
            'name.max' => 'El nombre debe tener como maximo 100 caracteres.',
            'photo.image' => 'El archivo debe ser una imagen.',
            'photo.mimes' => 'Ingresa un formato de imagen valido.',
            'photo.size' => 'El tamaño de la imagen debe ser maximo de 1MB.',
            'species_id.required' => 'El campo de especie es requerido.',
            'breed_id.requiered' => 'El campo raza es requerido.',
            'institution_id.required' => 'El campo institución es requerido'
        ];
    }
}

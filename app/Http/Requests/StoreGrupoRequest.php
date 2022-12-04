<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrupoRequest extends FormRequest
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
            'grupo' => 'required|integer',
            'domingo' => 'required|numeric',
            'segunda' => 'required|numeric',
            'terca' => 'required|numeric',
            'quarta' => 'required|numeric',
            'quinta' => 'required|numeric',
            'sexta' => 'required|numeric',
            'sabado' => 'required|numeric',
            'madrugada' => 'required|numeric',
            'dia' => 'required|numeric',
            'noite' => 'required|numeric',
        ];
    }
    
    public function messages()
    {
        return [
            'required' => 'O campo :attribute precisa ser preenchido',
            'numeric' => 'O campo :attribute precisa ser numérico',
        ];
    }
}

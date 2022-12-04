<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcaRequest extends FormRequest
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
            'nome' => 'required|unique:marcas|min:3|max:30',
            'imagem' => 'required|file|mimes:png,jpg',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatorio',
            'nome.unique' => 'Nome já cadastrado.',
            'nome.min' => 'Nome não pode conter menos de 3 caracteres.',
            'nome.max' => 'Nome pode conter no maximo 30 caracteres.',
            'imagem.required' => 'Imagem não selecionada',
            'imagem.file' => 'Erro ao enviar a imagem',
            'imagem.mimes' => 'O arquivo deve ser png ou jpg'
        ];
    }
}

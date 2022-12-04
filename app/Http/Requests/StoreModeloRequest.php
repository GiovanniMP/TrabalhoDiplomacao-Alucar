<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModeloRequest extends FormRequest
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
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos|min:3|max:30',
            'imagem' => 'required|file|mimes:png,jpg',
            'numero_portas' => 'required|integer|digits_between:1,5',
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean',
            'motor' => 'required',
            'transmissao' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'marca_id.exists' => 'Marca não cadastrada',
            'nome.required' => 'O campo nome é obrigatorio',
            'nome.unique' => 'Nome já cadastrado.',
            'nome.min' => 'Nome não pode conter menos de 3 caracteres.',
            'nome.max' => 'Nome pode conter no maximo 30 caracteres.',
            'imagem.required' => 'Imagem não selecionada',
            'imagem.file' => 'Erro ao enviar a imagem',
            'imagem.mimes' => 'O arquivo deve ser png ou jpg',
            'numero_portas.required' => 'Número de portas não informado',
            'numero_portas.integer' => 'Número de portas precisa ser um valor inteiro',
            'numero_portas.digits_between' => 'Número de portas válido de 1 à 5',
            'lugares.required' => 'Número de lugares precisa ser informado',
            'lugares.integer' => 'Número de lugares precisa ser um valor inteiro',
            'lugares.digits_between' => 'Número de lugares válido de 1 à 20',
            'air_bag.required' => 'O campo air bag precisa ser informado',
            'abs.required' => 'O campo abs precisa ser informado',
            'motor.required' => 'O campo motor precisa ser informado',
            'transmissao.required' => 'O campo transmissao precisa ser informado',
        ];
    }
}

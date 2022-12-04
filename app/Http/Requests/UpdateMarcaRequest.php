<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarcaRequest extends FormRequest
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
        $rules = [
            'nome' => 'required|unique:marcas,nome,' . $this->marca . '|min:3|max:30',
            'imagem' => 'required',
        ];

        if($this->method() === "PATCH"){

            $regrasDinamicas = array();
            foreach($rules as $input => $regra){
                if(array_key_exists($input, $this->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
            return $regrasDinamicas;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.unique' => 'Nome já cadastrado.',
            'nome.min' => 'Nome não pode conter menos de 3 caracteres.',
            'nome.max' => 'Nome pode conter no maximo 30 caracteres.',
            'imagem.required' => 'Imagem não selecionada',
        ];
    }
}

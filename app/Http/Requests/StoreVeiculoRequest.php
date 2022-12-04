<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVeiculoRequest extends FormRequest
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
            'user_id' => 'exists:users,id',
            'ano' => 'required|integer|digits:4',
            'marca' => 'required|min:3',
            'modelo' => 'required|min:3',
            'imagem_marca' => 'required|exists:marcas,imagem',
            'imagem_modelo' => 'required|exists:modelos,imagem',
            'contato' => 'required|regex:([0-9]{11})',
            'numero_portas' => 'required',
            'air_bag' => 'required',
            'abs' => 'required',
            'lugares' => 'required',
            'motor' => 'required',
            'transmissao' => 'required',
            'grupo' => 'required',
            'chassi' => 'required|min:17|max:17',
            'placa' => 'required|min:7|max:7',
            'cor' => 'required|min:3',
            'imagem' => 'required|file|mimes:png,jpg',
        ];
    }

    public function messages()
    {
        return [
            'user_id.exists' => 'Usuário com problemas',
            'ano.integer' => 'Ano precisa ser um valor inteiro',
            'ano.required' => 'O campo ano precisa ser preenchido',
            'ano.digits_between' => 'Número não aceito',
            'marca.required' => 'O campo marca precisa ser selecionado',
            'min' => 'O campo :attribute tem o minímo de caracteres aceitos sendo três',
            'modelo.required' => 'O campo modelo precisa ser selecionado',
            'imagem_marca.required' => 'Selecione uma marca',
            'imagem_modelo.required' => 'Selecione um modelo',
            'imagem_marca.exists' => 'Imagem não existente no banco',
            'imagem_modelo.exists' => 'Imagem não existente no banco',
            'contato.required' => 'O campo contato precisa ser preenchido',
            'contato.regex' => 'O campo contato possui erros no preenchimento, tente apenas números',
            'motor.required' => 'O campo motor precisa ser informado',
            'transmissao.required' => 'O campo transmissao precisa ser informado',
            'required' => 'O campo :attribute precisa ser informado',
            'placa.min' => 'O campo placa precisa ter no mínimo 7 caracteres',
            'placa.max' => 'O campo placa precisa ter no máximo 7 caracteres',
            'chassi.min' => 'O campo chassi precisa ter no mínimo 17 caracteres',
            'chassi.max' => 'O campo chassi precisa ter no máximo 17 caracteres',
            'imagem.required' => 'Imagem não selecionada',
            'imagem.file' => 'Erro ao enviar a imagem',
            'imagem.mimes' => 'O arquivo deve ser png ou jpg'
        ];
    }
}

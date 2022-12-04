<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvaliacaoRequest extends FormRequest
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
            'avaliacao' => 'required|in:1,2,3,4,5',
            'comentario' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute precisa ser preenchido',
            'avaliacao.in' => 'A avaliação precisa ter valores entre 1 e 5',
        ];
    }
}

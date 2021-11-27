<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if ($this->method() === 'POST') {
            return [
                'name' => 'required|min:3',
                'email' => 'required|unique:users,email|email',
                'password' => 'required|min:4',
                'cpf_cnpj' => 'required|numeric|unique:users,cpf_cnpj',
                'shopkeeper' => 'required|boolean'
            ];
        }

        return [ // Put
            'id' => 'required|numeric',
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:4',
            'cpf_cnpj' => 'required|numeric',
            'shopkeeper' => 'required|boolean'
        ];
    }
}

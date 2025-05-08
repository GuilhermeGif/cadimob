<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StorePessoaRequest extends FormRequest
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
        return [
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $idade = Carbon::parse($value)->age;
                    if ($idade < 18) {
                        $fail('O contribuinte deve ter pelo menos 18 anos de idade.');
                    }
                }
            ],
            'cpf' => [
                'required',
                'string',
                'unique:pessoas,cpf',
                function ($attribute, $value, $fail) {
                    if (!self::validaCPF($value)) {
                        $fail('O CPF informado não é válido.');
                    }
                }
            ],
            'sexo' => ['required', 'in:Masculino,Feminino'],
            'telefone' => ['nullable'],
            'email' => ['required', 'email', 'unique:pessoas,email'],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Digite o nome.',
            'nome.max' => 'O nome não pode exceder 255 caracteres.',
            'data_nascimento.required' => 'Insira uma data de nascimento.',
            'cpf.required' => 'Digite o CPF.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.email' => 'Email inválido.',
            'email.max' => 'O email não pode exceder 255 caracteres.',
            'email.unique' => 'O email informado já está em uso.',
        ];
    }

    public static function validaCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}


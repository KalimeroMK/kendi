<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
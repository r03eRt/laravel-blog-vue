<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            // email requerido y hay que ver que no estñe en la base de datos excepto si es el propio
            'email' => [
                'required',
                 Rule::unique('users')->ignore($this->route('user')->id)
                //Otra forma 'email' => ['required', 'unique:users']
            ]
        ];

        if($this->filled('password')) {
            $rules['password'] = ['confirmed', 'min:6'];
        }

        return $rules;
    }
}

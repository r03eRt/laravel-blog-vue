<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


// Usamos Request para aplicar reglas y autorización a la hora de usar request, por ejemplo traernos el validate aqui
class SaveRolesRequest extends FormRequest
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
     * Creamos una validacion para los metodos update y estore
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'display_name' => 'required'
        ];

        // Method es si el request del formulario es de tipo POST o PUT
        if($this->method() !== 'PUT') {
            $rules['name'] = 'required|unique:roles';
            //'name' => 'required|unique:roles'
        }

        return $rules;
    }

    public function messages() {
        return [
            'name.required' => 'El campo identificador es obligatorio',
            'name.unique' => 'Este identificador ya ha sido registrado',
            'display_name.required' => 'El campo nombre es obligatorio'
        ];
    }
}

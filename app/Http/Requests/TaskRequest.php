<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = ( ($this->getMethod() === 'PUT') ? $this->id : null);

        return [

            'name' => 'required',
            'description' => 'required',
            'expirated_at' => 'required',
            'user_id' => 'required'

        ];
    }

    public function attributes()
    {
        return [

            'name' => 'Nombre',
            'description' => 'Descripción',
            'expirated_at' => 'Fecha caducidad',
            'user_id' => 'Usuario',
             
        ];
    }

    public function messages()
    {
      
        return [

            'name.required' => 'Digite nombre(s)',
            'description.required' => 'Digite descripción',
            'expirated_at.required' => 'Digite fecha de caducidad',
            'user_id.required' => 'Seleccione un usuario',
           
        ];
    }
}

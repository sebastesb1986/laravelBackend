<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagsRequest extends FormRequest
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

        ];
    }

    public function attributes()
    {
        return [

            'name' => 'Nombre',
            'description' => 'Descripción',
             
        ];
    }

    public function messages()
    {
      
        return [

            'name.required' => 'Digite nombre(s)',
            'description.required' => 'Digite descripción',
           
        ];
    }
}

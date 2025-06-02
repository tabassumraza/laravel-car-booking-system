<?php

namespace App\Http\Requests\CarList;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class Request extends FormRequest
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
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        // 'carnum' => ['required', 'numeric','unique:carlists'],
           'carnum' => [
            'required',
            'numeric',
            Rule::unique('carlists')->ignore($this->route('id'))
        ],
        'status' => 'sometimes|string|in:available,booked' 

    ];
}
}

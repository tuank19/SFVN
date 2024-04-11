<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryEditRequest extends FormRequest
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
       $rules = [
            'nameEdit' => 'required',
            'slugEdit' => 'required',
        ];

        if (!$this->input('isParentEdit')) {
            $rules['parentIDEdit'] = 'required|exists:categories,uuid';
        }

        return $rules;
    }
}

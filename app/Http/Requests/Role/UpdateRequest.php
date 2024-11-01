<?php

namespace App\Http\Requests\Role;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateRequest extends FormRequest
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
        $id = $this->route('role');

        return [
            'role' => [
                'required',
                'string',
                Rule::unique('roles', 'role')
                    ->whereNull('deleted_at')
                    ->ignore($id),
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique('roles', 'slug')
                    ->whereNull('deleted_at')
                    ->ignore($id),
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('role')),
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [];
    }
}

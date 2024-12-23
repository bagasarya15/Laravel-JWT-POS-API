<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreRequest extends FormRequest
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
            'username' => ['required', 'string', Rule::unique('users', 'username')->whereNull('deleted_at')],
            'employee_id' => ['required', 'exists:employees,id', Rule::unique('users', 'employee_id')],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->password == '' || $this->password == null) {
            $this->merge([
                'password' => Hash::make("password")
            ]);
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // 'username.required' => 'username harus diisi',
            // 'username.unique' => "{$this->username} tidak tersedia",
        ];
    }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

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
        $userId = $this->route('user');

        return [
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username')->ignore($userId)->whereNull('deleted_at')
            ],
            'employee_id' => [
                'required',
                'exists:employees,id',
                Rule::unique('users', 'employee_id')->ignore($userId)->whereNull('deleted_at')
            ],
            'role_id' => ['required', 'exists:roles,id']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // $this->merge([
        // ]);
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

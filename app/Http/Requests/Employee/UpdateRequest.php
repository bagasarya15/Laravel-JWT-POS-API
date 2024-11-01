<?php

namespace App\Http\Requests\Employee;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

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
        $id = $this->route('employee');

        return [
            'nik' => ['required', 'string', Rule::unique('employees', 'nik')->whereNull('deleted_at')->ignore($id)],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'last_education' => ['required'],
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
            'nik.required' => 'NIK harus diisi.',
            'nik.string' => 'NIK harus berupa teks.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'firstname.required' => 'Nama depan harus diisi.',
            'lastname.required' => 'Nama belakang harus diisi.',
            'last_education.required' => 'Pendidikan terakhir harus diisi.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required'],
            'confirmed_password' => ['required', 'same:password'],
            'jabatan' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'numeric', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'confirmed_password.required' => 'Konfirmasi Password tidak boleh kosong',
            'confirmed_password.same' => 'Password tidak sama',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'role_id.required' => 'Role tidak boleh kosong',
        ];
    }
}

<?php

namespace App\Http\Requests\front;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "nik" => ['required', 'string', 'max:255', 'min:16'],
            "name" => ['required', 'string', 'max:255'],
            "email" => ['required', 'email', 'max:255', 'unique:masyarakats,email'],
            "password" => ['required', 'string', 'min:8', 'confirmed'],
            "password_confirmation" => ['required', 'string', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'nik.required' => 'NIK wajib diisi',
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak sama',
            'password_confirmation.required' => 'Konfirmasi Password wajib diisi',
            'password_confirmation.min' => 'Konfirmasi Password minimal 8 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'nik.min' => 'NIK harus 16 digit'
        ];
    }
}

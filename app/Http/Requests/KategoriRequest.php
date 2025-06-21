<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KategoriRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:kategoris,name,' . $this->id],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kategori harus diisi',
            'name.unique' => 'Kategori sudah ada',
            'name.string' => 'Kategori harus berupa string',
            'name.max' => 'Kategori maksimal 255 karakter',
        ];
    }
}

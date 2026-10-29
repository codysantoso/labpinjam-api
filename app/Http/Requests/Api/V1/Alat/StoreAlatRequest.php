<?php

namespace App\Http\Requests\Api\V1\Alat;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAlatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_alat' => ['required', 'string', 'max:50', 'unique:alats,kode_alat'],
            'nama_alat' => ['required', 'string', 'max:150'],
            'stok' => ['required', 'integer', 'min:0'],
            'kondisi' => ['nullable', 'string', 'max:100'],
        ];
    }
}

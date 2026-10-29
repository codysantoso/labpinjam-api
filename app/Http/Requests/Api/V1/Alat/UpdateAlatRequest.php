<?php

namespace App\Http\Requests\Api\V1\Alat;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlatRequest extends FormRequest
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
        $alatId = $this->route('alat') ?? $this->route('id');

        return [
            'kode_alat' => ['sometimes', 'string', 'max:50', Rule::unique('alats', 'kode_alat')->ignore($alatId)],
            'nama_alat' => ['sometimes', 'string', 'max:150'],
            'stok' => ['sometimes', 'integer', 'min:0'],
            'kondisi' => ['nullable', 'string', 'max:100'],
        ];
    }
}

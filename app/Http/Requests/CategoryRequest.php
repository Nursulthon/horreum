<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name' . $this->route('category'),
            //menggunakan tambahan route supaya bisa menambahkan exeption untuk validasi unique name
            //semisal jika yang ingin diganti hanya tagline, maka validasi unique name akan terlewati
            'tagline' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ];
    }
}

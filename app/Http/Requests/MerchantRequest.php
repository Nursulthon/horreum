<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:merchant,name' . $this->route('merchant'),
            'address' => 'required|string',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'phone' => 'required|string|unique:merchant,phone',
            'keeper_id' => 'required|exists:user,id',
        ];
    }
}

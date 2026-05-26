<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ho_ten' => ['required', 'string', 'max:100'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                Rule::unique('tai_khoan', 'email')->ignore($this->user()->id),
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:sizes,title'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

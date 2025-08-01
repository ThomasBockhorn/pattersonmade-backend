<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:100'],
            'company' => ['required', 'string', 'max:100'],
            'comment' => ['required', 'string'],
            'star' => ['required', 'in:oneStar,twoStar,threeStar,fourStar,fiveStar'],
        ];
    }
}

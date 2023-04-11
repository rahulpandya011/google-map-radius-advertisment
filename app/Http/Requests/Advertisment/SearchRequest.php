<?php

namespace App\Http\Requests\Advertisment;

use App\Http\Requests\FormRequest;

class SearchRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'radius' => 'sometimes'
        ];
    }

    public function messages(): array
    {
        return [
            'search.required' => 'Address is required',
            'lat.required' => 'Latitude is required',
            'lng.required' => 'Longitude is required'
        ];
    }
}

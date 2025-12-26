<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request validation for menu search
 */
class MenuSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'query' => 'required|string|min:2|max:255',
            'limit' => 'nullable|integer|min:1|max:50',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'query.required' => 'Query pencarian harus diisi.',
            'query.min' => 'Query pencarian minimal 2 karakter.',
            'query.max' => 'Query pencarian maksimal 255 karakter.',
            'limit.min' => 'Limit minimal adalah 1.',
            'limit.max' => 'Limit maksimal adalah 50.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'query' => trim($this->query),
        ]);
    }
}

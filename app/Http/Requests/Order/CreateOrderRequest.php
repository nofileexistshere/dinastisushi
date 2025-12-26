<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request validation for creating orders
 */
class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'menu_item_id' => 'required|integer|exists:menu_items,id',
            'quantity' => 'required|integer|min:1|max:10',
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
            'menu_item_id.required' => 'Menu item harus dipilih.',
            'menu_item_id.exists' => 'Menu item tidak ditemukan.',
            'quantity.required' => 'Jumlah harus diisi.',
            'quantity.min' => 'Jumlah minimal adalah 1.',
            'quantity.max' => 'Jumlah maksimal adalah 10.',
        ];
    }
}

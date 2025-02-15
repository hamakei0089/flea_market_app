<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'thumbnail' => ['required','mimes:jpeg,png'],
        'name' => ['required','max:255'],
        'brand_name' => ['nullable'],
        'category' => ['required'],
        'condition' => ['required'],
        'description' => ['required','max:255'],
        'price' => ['required' ,'numeric', 'min:1'],
        ];
    }
    public function messages(): array
    {
        return [
            'thumbnail.required' => '商品画像を選択して下さい。',
            'name.required' => '商品名を入力して下さい。',
            'name.max' => '名前は255文字以内で入力してください。',
            'category.required' => 'カテゴリーは1つ以上選択して下さい。',
            'condition.required' => '商品の状態を選択して下さい。',
            'description.required' => '商品の説明を入力してください。',
            'description.max' => '商品の説明は255文字以内で入力してください。',
            'price.required' => '金額を入力してください。',
            'price.numeric' => '金額は数字のみで入力してください。',
            'price.min' => '金額は１円以上で入力してください。',
        ];
    }
}

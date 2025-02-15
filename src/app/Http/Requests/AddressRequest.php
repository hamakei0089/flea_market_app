<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        'name' => ['required' ,'string' , 'max:255'],
        'post_code' => ['required' , 'regex:/^\d{3}-\d{4}$/'],
        'address' => ['required'],
        'building' => ['nullable' , 'string' , 'max:255'],
        'thumbnail' => ['nullable','mimes:jpeg,png'],
        ];
    }
     public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力して下さい。',
            'post_code.required' => '郵便番号を入力して下さい。',
            'post_code.regex' => '郵便番号は「123-4567」の形式で入力してください。',
            'address.required' => '住所を入力して下さい。',
            'thumbnail.mimes' => '画像は JPEG または PNG 形式でアップロードしてください。',
        ];
    }
}

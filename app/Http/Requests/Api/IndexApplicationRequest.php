<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class IndexApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'searchable' => 'required|array',
            'searchable.*' => 'in:id,firstname,lastname,address,city,zip,voivodeship,email,phone,shop_type,number_receipt,img_receipt,img_ean,whence.name,product.name,shop.name,buyday,created_at,legal_1,legal_2,legal_3,legal_4,legal_5',
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer|min:1|max:100',
            'filter' => 'nullable|json',
            'sort' => 'nullable|in:id,firstname,lastname,address,city,zip,voivodeship,email,phone,shop_type,number_receipt,img_receipt,img_ean,whence.name,product.name,shop.name,buyday,created_at,legal_1,legal_2,legal_3,legal_4,legal_5',
            'order' => 'nullable|in:asc,desc',
            'search' => 'nullable'
        ];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->input('sort'))) {
                $this->merge(['sort' => 'id']); // Domyślna kolumna sortowania
            }

            if (empty($this->input('order'))) {
                $this->merge(['order' => 'asc']); // Domyślny kierunek sortowania
            }
        });
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'The given data was invalid',
            'errors' => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
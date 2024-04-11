<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;

class OrderRequest extends FormRequest
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
        $rules = [
            'orderDate' => 'required',
            'orderStatus' => 'required',
            'orderNumber' => 'required',
            'customerUUID' => 'required',
        ];

        if ($this->input('data')) {

            $productData = json_decode($this->input('data'), true);
            $productUUIDs = array_keys($productData);
            if(!$productUUIDs) {
                $rules['product'] = 'required';
            }else {
                foreach ($productData as $key => $quantity) {
                    $prod = DB::table('products')->where('uuid', $key)->first();

                    if(!$prod) {
                     $rules['product'] = 'required';
                    }
                 }
            }
        }else {
            $rules['product'] = 'required';
        }

        return $rules;


    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use PharIo\Manifest\Author;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'product_name' => 'required|min:6',
            'product_price' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            // 'product_name.required' => 'Truong :attribute bat buoc phai nhap',
            // 'product_name.min' => 'Truong :attribute khong duoc nho hon :min ky tu',
            // 'product_price.required' => 'Gia san pham bat buoc phai nhap',
            // 'product_price.integer' => 'Gia san pham phai la so'
            // 'product_name.required' => 'Truong :attribute san pham bat buoc phai nhap',
            'product_name.required' => ':attribute bat buoc phai nhap',
            'product_name.min' => ':attribute khong duoc nho hon :min ki tu',
            'product_price.required' => ':attribute bat buoc phai nhap',
            'product_price.integer' => ':attribute phai la so'
        ];
    }

    public function attributes()
    {
        return [
            'product_name' => 'Ten san pham',
            'product_price' => 'Gia san pham',
        ];
    }

    protected function withVallidator($validator){
        $validator->after(function ($validator){
            if ($validator->errors()->count()>0){
                $validator->errors()->add('msg', 'Da co loi xay ra, vui long kiem tra lai');
            }
            // if ($this->somethingElseIsInvalid()){
            //     $validator->errors()->add('msg', 'Da co loi xay ra, vui long kiem tra lai');
            // }
        });
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'create_at' => date('Y-m-d H:i:s'),
        ]);
    }

    protected function failedAuthorization()
    {
        //throw new AuthorizationException('Ban dang truy cap vao khu vuc cam');
        //throw new HttpResponseException(redirect('/')->with('msg', 'Bạn không có quyền truy cập')->with('type', 'danger'));

        throw new HttpResponseException(abort(404));


    }   
}
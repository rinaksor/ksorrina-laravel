<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ProductRequest;

use App\Rules\Uppercase;

Use Illuminate\Support\Facades\Validator;

use  Illuminate\Support\Facades\DB;
//use DB;

class HomeController extends Controller
{
    public $data = [];
    public function index(){
        $this->data['title'] = 'Dao tao lap trinh web';

        $this->data['message'] = 'Dang ky tai khoan thanh cong';

        //$users = DB::select('SELECT * FROM users WHERE email=:email', ['email' => 'rina.web@gmail.com']);
        //dd($users);


        return view('clients.home', $this->data);
    }

    public function products(){
        $this->data['title'] = 'San pham';

        return view('clients.products', $this->data);
    }

    public function getAdd(){
        $this->data['title'] = 'Them San pham';

        $this->data['errorMessage'] = 'Vui long kiem tra lai du lieu';
        return view('clients.add', $this->data);
    }

    public function postAdd(ProductRequest $request){


        $rules = [
            //'product_name' => ['required' , 'min:6', function($attributes, $value,$fail){
                // if($value!=mb_strtoupper($value, 'UTF-8')){
                //     //xay ra loi
                //     $fail('Truong :attribute khong hop le');
                // }
                //isUppercase($value,'Truong :attribute khong hop le', $fail);
                'product_name' => ['required', 'min:6'],
                'product_price' => ['required', 'integer']
                ];

        $message = [
            'required' => 'Truong :attribute bat buoc phai nhap',
            'min' => 'Truong :attribute khong duoc nho hon :min ky tu',
            'integer' => 'Truong :attribute phai la so'
        ];

        $attributes = [
                'product_name' => 'Ten san pham',
                'product_price' => 'Gia san pham',
        ];

        
        
        //$vatidator = Validator::make($request->all(), $rules, $message, $attributes);
        
        //$vatidator->validate();

        //$request->validate($rules, $message);
        
        return response()->json(['status'=>'success']);
        
        
        //$vatidator->validate();

        // if ($vatidator->fails()){
        //     $vatidator->errors()->add('msg', 'Vui long kiem tra lai du lieu');
        //     //return 'Validate that bai';
        // }else{
        //     //return 'Validate thanh cong';
        //     return redirect()->route('product')->with('msg', 'Validate thanh cong');
        // }

        // return back()->withErrors($vatidator);

        // $request->validate($rules, $message);


        //xu ly viec them du lieu database
    }

    public function putAdd(Request $request){
        return 'Phuong thuc PUT';
        dd($request);
    }

    public function getArr(){
        $contentArr = [
            'name' => 'laravel 8.x',
            'lesson' => 'Khóa học lập trình Laravel',
            'academy' => 'Unicode Academy'
        ];
    
        return $contentArr;
    }

    public function downloadImage(Request $request){
        if (!empty($request->image)){
            $image = trim($request->image);

            $fileName = 'image_'.uniqid().'.jpg';
            //$fileName = basename($image);

            // return response()->streamDownload(function() use( $image){
            //     $imageContent = file_get_contents($image);
            //     echo $imageContent;
            // }, $fileName);

            return response()->download($image, $fileName);
        }
    }
    public function dowloadDoc(Request $request){
        if (!empty($request->file)){
            $file = trim($request->file);

            $fileName = 'tai-lieu_'.uniqid().'.pdf';
            //$fileName = basename($image);

            // return response()->streamDownload(function() use( $image){
            //     $imageContent = file_get_contents($image);
            //     echo $imageContent;
            // }, $fileName);
            
            $headers = [
                'Content-Type' => 'application/pdf'
            ];
            return response()->download($file, $fileName, $headers);
        }
    }
    // public function isUppercase($value, $message, $fail){
    //     if($value!=mb_strtoupper($value, 'UTF-8')){
    //         //xay ra loi
    //         $fail($message);
    //     }
    // }
}

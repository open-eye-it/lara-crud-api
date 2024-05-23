<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->category = new ProductCategory;
    }

    public function create(Request $request){
        $input = $request->all();
        if(isset($input['pc_image'])){
            $file_path = 'categories';
            $filename = uniqid().'.png';
            $path = $request->file('pc_image')->storeAs($file_path, $filename);
            $input['pc_image'] = (String)json_encode(['file_path' => $file_path, 'filename' => $filename]);
        }
        $input['pc_id'] = $this->generateBarcodeNumber();
        $input['pc_slug'] = Str::slug($input['pc_name']);
        $insert = $this->category->store($input);
        if($insert){
            return response()->json(['status' => 'success', 'message' => 'Category store successfully'], 200);
        }else{
            return response()->json(['status' => 'fail', 'message' => 'Category not store'], 201);
        }
    }

    public function single_category($pc_id){
        $category = $this->category->single_category($pc_id);
        if($category != null || !empty($category)){
            return response()->json(['status' => 'success', 'message' => 'Category found', 'data' => $category]);
        }else{
            return response()->json(['status' => 'success', 'message' => 'Category not found'], 201);
        }
    }

    public function update(Request $request, $pc_id){
        $input = $request->all();
        if(isset($input['pc_image']) && $input['pc_image'] != ''){
            $file_path = 'categories';
            $filename = uniqid().'.png';
            $path = $request->file('pc_image')->storeAs($file_path, $filename);
            $input['pc_image'] = (String)json_encode(['file_path' => $file_path, 'filename' => $filename]);
        }
        $input['pc_slug'] = Str::slug($input['pc_name']);
        $update = $this->category->update_data($input, $pc_id);
        if($update){
            return response()->json(['status' => 'success', 'message' => 'Category update successfully'], 200);
        }else{
            return response()->json(['status' => 'fail', 'message' => 'Category not update'], 201);
        }
    }

    public function destroy($pc_id){
        $delete = $this->category->delete_data($pc_id);
        return response()->json(['status' => 'success', 'message' => 'Category delete successfully'], 200);
    }

    public function list(){
        $list = $this->category->list();
        if($list != null || !empty($list)){
            return response()->json(['status' => 'success', 'message' => 'Category found', 'data' => $list]);
        }else{
            return response()->json(['status' => 'success', 'message' => 'Category not found'], 201);
        }
    }

    function generateBarcodeNumber() {
        $number = mt_rand(1000000000, 9999999999); // better than rand()
    
        // call the same function if the barcode exists already
        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }
    
        // otherwise, it's valid and can be used
        return $number;
    }

    function barcodeNumberExists($number) {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return $this->category::where('pc_id', $number)->exists();
    }
}

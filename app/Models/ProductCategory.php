<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = ['pc_id', 'pc_name', 'pc_slug', 'pc_image'];

    public function store($data){
        return Static::create($data);
    }

    public function single_category($pc_id){
        return Static::where('pc_id', $pc_id)->first();
    }

    public function update_data($data, $pc_id){
        return Static::where('pc_id', $pc_id)->update($data);
    }

    public function delete_data($pc_id){
        return Static::where('pc_id', $pc_id)->delete();
    }

    public function list(){
        return Static::get();
    }
}

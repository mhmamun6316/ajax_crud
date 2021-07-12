<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return view('crud.index');
    }
    public function getall(){
        $data = Product::all();
        return response()->json($data);
    }

    public function store_product(Request $request){

        $validated = $request->validate([
            'name' => 'required|unique:products|max:255',
            'description' => 'required',
           ]);

        $data=new Product;
        $data->name=$request->name;
        $data->description=$request->description;
        $data->price=$request->price;
        if($request->hasFile('image')) {
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file=move('uploads/',$filename);
            $data->photo=$filename;
        }
        else{
            $data->photo='error';
        }
        $data->save();
        return response()->json($data);
    }

    public function edit_product($id){
        $data=Product::find($id);
        return response()->json($data);
    }

    public function update_product(Request $request,$id)
    {
        $data=Product::find($id);
        $data->name=$request->name;
        $data->description=$request->description;
        $data->price=$request->price;
        $data->save();
        return response()->json($data); 
    }

    public function delete_product($id){
        $data=Product::find($id);
        $data->delete();
        return response()->json($data);
    }

}

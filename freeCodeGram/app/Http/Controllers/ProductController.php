<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        // $title="CHUJ";
        // $description="Jeszcze jak";
        // $data=[
        //     'tel'=>"Realme 7",
        //     'tel2'=>"honor 7"
        // ];
        //return view('products.index',compact('title des'));
        //return view('products.index')->with('data',$data);
        // return view('products.index',['data'=>$data]);
        print_r(route('products'));
        return view('products.index');
    }
    public function show($id){
        $data=[
            '1'=>"Realme 7",
            '2'=>"honor dsa7"
        ];
        return view('products.index',['properties'=>$data[$id]??'Product'.$id.'Dose not exist']);
    }
}

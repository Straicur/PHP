<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('index');
    }
    public function about(){
        $name="Damian";
        $names=["Damian","Kinga","Ania","Maciek"];
        return view('about',[
            'name'=>$name,
            'names'=>$names
        ]);
    }
}

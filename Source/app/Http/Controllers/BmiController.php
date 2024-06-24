<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmiController extends Controller
{
    public function index()
    {
       return view('bmi',[
        'title' => 'Tính chỉ số BMI'
       ]);
    }

}

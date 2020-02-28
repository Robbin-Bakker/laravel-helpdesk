<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function hi($id){
        return view('testparameter')->with('id', $id);
    }

    public function generation($age){
        $currentYear = 2020;
        if($age > $currentYear-$currentYear && $age < $currentYear-2000) $result = 'Gen Z';
        elseif($age >= $currentYear-2000 && $age < $currentYear-1980) $result = 'Gen Y';
        elseif($age >= $currentYear-1980 && $age < $currentYear-1965) $result = 'Gen X';
        elseif($age >= $currentYear-1965 && $age < $currentYear-1946) $result = 'Baby Boomer';
        elseif($age >= $currentYear-1946 && $age < $currentYear-1925) $result = 'Silent Generation';
        else $result = 'G.I. Generation';
        return view('generation')->with('result', $result);
    }

    public function random($min, $max){
        if($min > $max) $message = 'min moet lager zijn dan max';
        else return view('random')->with('randomNumber', rand($min, $max));
        return view('random')->with('message', $message);
    }
}

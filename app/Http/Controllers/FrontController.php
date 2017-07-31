<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index($act = 'def')
    {
    	return $this->$act();
    }

    public function def(){
    	return view('front.default');
    }
}

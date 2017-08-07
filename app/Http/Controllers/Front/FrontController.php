<?php

namespace app\Http\Controllers\Front;

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

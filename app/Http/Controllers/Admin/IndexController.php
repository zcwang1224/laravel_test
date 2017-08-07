<?php

namespace app\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected function index()
    {
    	return view('admin.content.index', $this->data);
    }
}

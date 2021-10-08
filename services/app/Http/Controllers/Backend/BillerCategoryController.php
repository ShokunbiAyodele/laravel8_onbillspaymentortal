<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillerCategoryController extends Controller
{
    
    public function BillerCategory(){
        return view('admin.category_view');
    }

    public function BillerCategoryTwo(){
        return view('admin.category_two');
    }
}

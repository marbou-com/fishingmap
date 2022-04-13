<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function index(Request $Request)
    {

        return view('pages.vue.index');


    }
    public function index2(Request $Request)
    {

        return view('pages.vue.index2');


    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class IndexController extends Controller
{
    public function index(){
      $schoolname = DB::Table('School')
                      ->where('School_check',true)
                      ->get();
      $SchoolTitle = $schoolname[0]->Home_Title;
      $SchoolSecTitle = $schoolname[0]->Home_SecTitle;
       return view("index",compact('SchoolTitle','SchoolSecTitle'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Model\CommandLog;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function __construct()
    {
        $this->middleware("onlyUser");
    }


    public function index(Request $request){
        return view("logs.index",['logs'=>CommandLog::orderBy('id','desc')->paginate(50)]);
    }
}

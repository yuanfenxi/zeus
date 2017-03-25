<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HostManageController extends Controller
{
    //

    /**
     * HostManageController constructor.
     */
    public function __construct()
    {
        $this->middleware("onlyUser");
    }

    public function create(Request $request){
        return view("host.create");
    }
    public function postCreate(Request $request){
        
    }

    public function index(Request $request){

    }

    public function remove(Request $request,int $id){

    }

    public function edit(Request $request,int $id){

    }

    public function postEdit(Request $request,int $id){

    }
}

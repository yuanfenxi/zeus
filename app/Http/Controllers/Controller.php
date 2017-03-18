<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redirectWithSucc(Request $request, $msg)
    {
        $request->session()->flash("success", $msg);
        return redirect()->back();
    }

    public function redirectWithNotice(Request $request, $msg)
    {
        $request->session()->flash("notice", $msg);
        return redirect()->back();
    }

    public function redirectWithError(Request $request, $msg)
    {
        $request->session()->flash("error", $msg);
        return redirect()->back()->withInput($request->all());
    }

    public function gotoWithSucc(Request $request, $msg, $url)
    {
        $request->session()->flash("success", $msg);
        return redirect($url);
    }

    public function gotoWithNotice(Request $request, $msg, $url)
    {
        $request->session()->flash("notice", $msg);
        return redirect($url);
    }
}

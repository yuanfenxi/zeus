<?php

namespace App\Http\Controllers;

use App\Model\AgentCommand;
use Illuminate\Http\Request;

class Agent extends Controller
{
    //
    function report(Request $request){
        $agentCommand = new AgentCommand();
        $agentCommand->command = $request->input("command");
        $agentCommand->hostname = $request->input("hostname");
        $agentCommand->result = $request->input("result");
        $agentCommand->output = $request->input("output");
        if($agentCommand->save()){
            return ['code'=>200,'msg'=>""];
        }else{
            return ['code'=>500,"msg"=>"保存失败"];
        }
    }
}

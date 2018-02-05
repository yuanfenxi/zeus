<?php

namespace App\Http\Controllers;

use App\AppInstance;
use App\Node;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function instancesOfNode(Request $request)
    {
        $ip = $request->getClientIp();
        $node = Node::where("ip", $ip)->first();
        if ($node) {
            $target = [];
            foreach ($node->instances as $ins) {
                $ins->template = $ins->app->language;
                $target[] = $ins;
            }
            return ["code" => 200, "data" => $target];
        } else {
            return ['code' => 404, "msg" => "node not found"];
        }
    }
    public function reportDocker(Request $request)
    {
        $t = time();
        $count = 0;
        $instanceInput = $request->input("instances");
        $instances = explode(",", $instanceInput);
        $reported = [];
        foreach ($instances as $instance) {
            if (!empty($instance)) {
                $instance = trim($instance);
                $appInstance = AppInstance::where("instance_name", $instance)->first();
                if ($appInstance) {
                    $appInstance->status = "online";
                    $appInstance->last_check_at = $t;
                    if ($appInstance->save()) {
                        $count++;
                    }
                    $reported[] = $instance;
                }
            }
        }

        return ["code" => 200, "data" => $count, "instances" => $reported];
    }
}

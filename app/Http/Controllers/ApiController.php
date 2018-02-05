<?php

namespace App\Http\Controllers;

use App\AppInstance;
use Illuminate\Http\Request;

class ApiController extends Controller
{
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

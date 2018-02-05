<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class App extends Model
{
    //


    public function instances()
    {
        return $this->hasMany('App\AppInstance');
    }

    public function groups()
    {
        return $this->hasMany('App\Model\Group');
    }

    public static function getAllEnv($appName,$groupName){
        $app = App::where("name", $appName)->first();
        if (!$app) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_NOT_FOUND, "error:app $appName not found");
            return $response;
        }

        $group = Group::where("name", $groupName)->where("app_id",$app->id)->first();
        if (!$group) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_NOT_FOUND, "error:group $groupName not found");
            return $response;
        }

        $values = Value::where("app_id", $app->id)->where("group_id", $group->id)->get();
        //return $group->toArray();
        $res = [];
        foreach ($values as $value) {
            $res[$value->variable->name] = $value->value;
        }
        return $res;
    }

    public static function buildEnv($appName, $groupName)
    {
        $res = self::getAllEnv($appName, $groupName);
        $lines = [];
        foreach ($res as $k => $v) {
            if (strpos($v, "'") !== false) {
                $lines[] = $k . "=" . '"' . $v . '"';
            } else {
                $lines[] = $k . "=" . "$v";
            }
        }
        return join("\n", $lines);
    }
    
    
}

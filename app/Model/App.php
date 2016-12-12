<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class App extends Model
{
    //

    public function groups()
    {
        return $this->hasMany('App\Model\Group');
    }

    public static function buildEnv($appName, $groupName)
    {
        $app = App::where("name", $appName)->first();
        if (!$app) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_NOT_FOUND, "error:app $appName not found");
            return $response;
        }

        $group = Group::where("name", $groupName)->first();
        if (!$group) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_NOT_FOUND, "error:group $groupName not found");
            return $response;
        }

        $values = Value::where("app_id", $app->id)->where("group_id", $group->id)->get();
        $res = [];
        foreach ($values as $value) {
            $res[$value->variable->name] = $value->value;
        }
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

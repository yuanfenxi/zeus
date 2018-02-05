<?php

namespace App;

use App\Model\App;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{

    public function instances()
    {
        return $this->hasMany('App\AppInstance');
    }

    /**
     * 返回该节点上可以分配的端口；
     * @return int|mixed
     * @throws \Exception
     */
    public function decidePort()
    {
        $row = AppInstance::where("node_id", $this->id)->orderBy("port", "desc")->first();
        if ($row) {
            if ($row->port >= $this->maxPort) {
                throw new \Exception("too many instances in same node");
            }
            return $row->port + 1;
        } else {
            return $this->minPort;
        }
    }

    public function afterCreate()
    {
        $templates = [
            "nginx" => 80,
            "portman" => 7777,
            "ws" => 4998,
            "proxy" => 7788
        ];
        foreach ($templates as $template => $port) {
            $app = App::where("name", $template)->first();
            if ($app) {
                $instance = new AppInstance();
                $instance->node_id = $this->id;
                $instance->app_id = $app->id;
                $instance->port = $port;
                $instance->instance_name = "default_" . $app->name;
                $instance->save();

            }
        }
    }
}

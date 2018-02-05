<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
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
}

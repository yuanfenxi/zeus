<?php

namespace App\Model;

use App\Zeus\HostHelper;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //

    public function app(){
        return $this->belongsTo('App\Model\App','app_id');
    }

    public function someCommandOnSingleHost($cwd,$host,$command){
        $realCommand = "ssh -o ConnectTimeout=3 $host 'cd $cwd && $command'";
        exec($realCommand, $output, $return);
        if($return!=0){
            throw new \Exception($realCommand .' failed on host:.'.$host.' ,cwd:.'.$cwd.':return '.$return.",output:".join("\n",$output));
        }
        return $output;
    }
    public function doOperation($operation){
        $hosts = HostHelper::parseHost($this->hosts);
        if(empty($hosts)){
            throw  new \Exception("can't get hosts of app:{$this->app->name},group:{$this->name} ");
        }
        if($hosts){
            foreach($hosts as $host) {
                switch ($operation){
                    case 'gitPull':
                        $this->someCommandOnSingleHost($this->deployPath, $host, 'git pull');
                        break;
                    case 'migrate':
                        $this->someCommandOnSingleHost($this->deployPath, $host, 'php artisan migrate');
                        break;
                }
            }
        }
    }
}

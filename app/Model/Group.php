<?php

namespace App\Model;

use app\Misc\EnvStringLoader;
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

    public function readRemoteEnv(){
        $hosts = HostHelper::parseHost($this->hosts);
        if(empty($hosts)){
            throw  new \Exception("can't get hosts of app:{$this->app->name},group:{$this->name} ");
        }
        $contents = [];
        if($hosts){
            foreach($hosts as $host) {
                $res = $this->someCommandOnSingleHost($this->deployPath, $host, 'cat .env|sort');
                $contents[md5($res)] = $res;
            }
        }
        if(sizeof(array_keys($contents))!=1){
            throw new \Exception("error:");
        }
        $content = array_pop($contents);
        $envStringLoader = new EnvStringLoader($content);
        $envStringLoader->load();
        $config = $envStringLoader->getConfig();

        $app = $this->app;
        foreach($config as $k=>$v){
            $variable = Variable::where("app_id",$app->id)->where("name",$k)->first();
            if(empty($variable)){
                $variable = new Variable();
                $variable->app_id = $app->id;
                $variable->name = $k;
                if(!$variable->save()){
                    $this->error("variable ".$k." save failed");
                }
            }
            $variable->putValue($this->id, $v);
        }


        return $config;
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

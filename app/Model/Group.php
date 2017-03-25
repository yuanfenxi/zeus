<?php

namespace App\Model;

use App\Misc\EnvStringLoader;
use App\Zeus\HostHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use NvwaCommon\Uic\RemoteUser;

class Group extends Model
{
    //

    public function app(){
        return $this->belongsTo('App\Model\App','app_id');
    }

    public function someCommandOnSingleHost($cwd,$host,$command){
        $realCommand = "ssh -o ConnectTimeout=3 $host 'cd $cwd && $command'";
        exec($realCommand, $output, $return);
        $commandLog = new CommandLog();
        $commandLog->command = $realCommand;
        $commandLog->output = join("\n",$output);
        $commandLog->result = $return;
        $commandLog->email = RemoteUser::getCurrentUser()->email;
        if(!$commandLog->save()){
            Log::error("command can't write to databse.".$realCommand.",return:$return,output:".join("\n",$output));
        }
        if($return!=0){
            throw new \Exception($realCommand .' failed on host:.'.$host.' ,cwd:.'.$cwd.':return '.$return.",output:".join("\n",$output));
        }
        return $output;
    }

    public function readRemoteEnv(){
        $content = $this->readRemoteEnvContent();
        $config = $this->syncVariablesWithEnvContent($content);
        
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
                    case 'writeEnv':
                        $this->someCommandOnSingleHost('/home/x/htdocs/zeus.glz8.net/', $host, 'php artisan zeus:updateEnv '.$this->app->name.' '.$this->name);
                        break;
                }
            }
        }
    }

    /**
     * @param $content
     * @return array
     * @throws \app\DBException
     */
    public function syncVariablesWithEnvContent($content)
    {
        $envStringLoader = new EnvStringLoader($content);
        $envStringLoader->load();
        $config = $envStringLoader->getConfig();

        $app = $this->app;
        foreach ($config as $k => $v) {
            $variable = Variable::where("app_id", $app->id)->where("name", $k)->first();
            if (empty($variable)) {
                $variable = new Variable();
                $variable->app_id = $app->id;
                $variable->name = $k;
                if (!$variable->save()) {
                    $this->error("variable " . $k . " save failed");
                }
            }
            $variable->putValue($this->id, $v);
        }
        return $config;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function readRemoteEnvContent()
    {
        $hosts = HostHelper::parseHost($this->hosts);
        if (empty($hosts)) {
            throw new \Exception(trans('zeus.hosts-list-empty', ['app' => $this->app->name, 'group' => $this->name]));
        }
        $contents = [];
        if ($hosts) {
            foreach ($hosts as $host) {
                $res = $this->someCommandOnSingleHost($this->deployPath, $host, 'cat .env|sort');
                $txt = join("\n", $res);
                $contents[md5($txt)] = $txt;
            }
        }
        if (sizeof(array_keys($contents)) != 1) {
            throw new \Exception(trans('zeus.env-different-among-hosts'));
        }
        $content = array_pop($contents);
        return $content;
    }
}

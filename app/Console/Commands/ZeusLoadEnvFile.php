<?php

namespace App\Console\Commands;

use App\Misc\EnvHelper;
use App\Model\App;
use App\Model\Group;
use App\Model\Variable;
use Illuminate\Console\Command;

class ZeusLoadEnvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zeus:loadEnv {app : app name} {group : group name} {file : envFile path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $appName = $this->argument("app");
        $groupName = $this->argument("group");
        $file = $this->argument("file");
        if(empty($appName)){
            $this->error("app can't be null");
            return;
        }
        if(empty($groupName)){
            $this->error("group can't be null");
            return;
        }
        if(empty($file)){
            $this->error("file can't be null");
            return ;
        }


        $app = App::where("name",$appName)->first();
        if(empty($app)){
            $this->error("app ".$appName." can't found");
            return;
        }

        $group = Group::where("name",$groupName)->where("app_id",$app->id)->first();
        if(empty($group)){
            $this->error("group ".$groupName." of app:".$appName." can't found");
            return;
        }

        $envHelper = new EnvHelper($file);
        $envHelper->load();
        $config = $envHelper->getConfig();
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
            $variable->putValue($group->id, $v);
        }
       
    }
}

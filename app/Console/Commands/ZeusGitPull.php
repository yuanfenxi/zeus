<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Zeus\Deploy;
use App\Model\App;
use App\Model\Group;

class ZeusGitPull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zeus:gitPull {app : appname} {group : groupName}';

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
        if (empty($appName)) {
            $this->error("app can't be null");
            return;
        }
        if (empty($groupName)) {
            $this->error("group can't be null");
            return;
        }
        $app = App::where("name", $appName)->first();
        if (empty($app)) {
            $this->error("app " . $appName . " can't found");
            return;
        }
        $group = Group::where("name", $groupName)->where("app_id", $app->id)->first();
        if (empty($group)) {
            $this->error("group " . $groupName . " of app:" . $appName . " can't found");
            return;
        }
        $deploy = new Deploy();
        $output = $deploy->gitUpdate($app, $group);
        $this->warn(join("\n", $output));
        $this->info("恭喜,git pull完成\nCongratulations! git pull succeed!");
    }
}
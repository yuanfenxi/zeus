<?php

namespace App\Console\Commands;

use App\Model\App;
use App\Model\Group;
use Illuminate\Console\Command;

class DeployProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zeus:deploy {app : app name} {group : group name}';

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
        $this->deployApp($app, $group);

    }

    public function deployApp($app, $group)
    {
        $codeBase = $group->codeBase;
        //每次发布,都将group的version加1;
        $newVersion = $group->version = $group->version + 1;
        if (!$group->save()) {
            throw new \Exception('cant update version ');
        }
        $appName = $app->name;
        $codeBase = $this->normalize($codeBase);
        if (!file_exists($codeBase . "/$appName")) {
            mkdir($codeBase . "/$appName", 0755, true);
        }
        $targetDir = $this->normalize($codeBase . "/" . $appName . "/" . $newVersion);
        $command = "git clone " . $app->git_repo . " " . $targetDir;
        exec($command, $output, $return);
        if ($return != 0) {
            throw new \Exception("git clone failed:return:" . $return . ", output:" . join("\n", $output) . ",command:" . $command);
        }
        $envContent = App::buildEnv($appName, $group->name);
        if (!file_put_contents($targetDir . "/.env", $envContent)) {
            throw new \Exception('create .env file failed');
        }
        if (!file_put_contents($targetDir . "/.version", $group->version)) {
            throw new \Exception('create .version file failed');
        }
        if (file_exists($group->deployPath)) {
            if (file_exists($codeBase . "/" . $appName . "/last")) {
                if (!rmdir($codeBase . "/" . $appName . "/last")) {
                    throw new \Exception("rm old " . $codeBase . "/" . $appName . "/last failed");
                }
            }
            if (!rename($group->deployPath, $codeBase . "/" . $appName . "/last")) {
                throw new \Exception('move deployPath failed');
            }
        }
        if (!rename($codeBase . "/" . $appName . "/" . $newVersion, $group->deployPath)) {
            throw new \Exception('move new code to deployPath failed');
        }
        $this->info("恭喜,发布完成\nCongratulations! deploy succeed!");
    }

    public function normalize($path)
    {
        return rtrim($path, "/\\");
    }
}

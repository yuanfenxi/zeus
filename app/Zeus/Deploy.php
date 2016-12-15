<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2016/12/13
 * Time: 下午6:30
 */

namespace App\Zeus;
use App\Model\App;

class Deploy
{
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
                exec("rm -rf ".$codeBase . "/" . $appName . "/last",$output,$returnValue);
                if($returnValue!=0){
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

    }

    public function rollbackApp($app, $group)
    {
        $codeBase = $group->codeBase;
        $appName = $app->name;
        $codeBase = $this->normalize($codeBase);
        if (!file_exists($codeBase . "/$appName")) {
            mkdir($codeBase . "/$appName",0755,true);
        }
        $last = $this->normalize($codeBase . "/" . $appName . "/last");
        if (!file_exists($last)) {
            throw new \Exception('path:' . $last . " not exists");
        }
        $deployPath = $this->normalize($group->deployPath);
        if(!rename($deployPath,$deployPath."-".$group->version)){
            throw new \Exception("move failed;");
        }
        if (!rename($last."/", $group->deployPath."/")) {
            throw new \Exception(' rollback deploy failed');
        }
    }



    public function gitUpdate($app,$group){
        chdir($group->deployPath);
        $command = "git pull";
        exec($command, $output, $return);
        if($return!=0){
            throw new \Exception('git pull failed:return '.$return.",output:".join("\n",$output));
        }
        return $output;
    }
    public function migrate($app,$group){

        $command = "php ".$group->deployPath."/artisan migrate";
        exec($command, $output, $return);
        if($return!=0){
            throw new \Exception('git pull failed:return '.$return.",output:".join("\n",$output));
        }
        return $output;
    }
    public function updateEnv($app,$group){
        $envContent = App::buildEnv($app->name, $group->name);
        if(!$envContent){
            throw new \Exception('cant build app .env file content');
        }

        if (!file_put_contents($group->deployPath . "/.env", $envContent)) {
            throw new \Exception('create .env file failed');
        }
        return $envContent;
    }
    public function normalize($path)
    {
        return rtrim($path, "/\\");
    }
}
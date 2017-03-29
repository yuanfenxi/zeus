<?php

namespace App\Http\Controllers;

use App\DBException;
use App\Misc\EnvStringLoader;
use App\Model\App;
use App\Model\Group;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NvwaCommon\Uic\RemoteUser;

class ConfigManager extends Controller
{
    //

    /**
     * ConfigManager constructor.
     */
    public function __construct()
    {
        $this->middleware("onlyUser");
    }

    public function apps(Request $request)
    {
        return view("config.app.index", ['apps' => App::paginate(50)]);
    }

    public function addApp(Request $request)
    {
        return view("config.app.create");
    }

    public function groupViewEnv(Request $request, $groupId)
    {
        $group = Group::find($groupId);
        if (!$group) {
            return $this->redirectWithError($request, trans('zeus.group-not-exists'));
        }
        $env =   App::buildEnv($group->app->name, $group->name);
        return view("config.group.view", [
            'app' => $group->app, 'group' => $group,'env'=>$env]);
    }


    public function appEdit(Request $request, $id)
    {
        return view("config.app.edit", ['app' => App::where('id', $id)->first()]);
    }

    public function appRemove(Request $request, $id)
    {

    }

    public function appView(Request $request, $id)
    {
        return view("config.app.view", ['app' => App::find($id)]);
    }


    public function appPostEdit(Request $request, $id)
    {
        $app = App::where("id", $id)->first();
        if (!$app) {
            return "app not found";
        } else {
            $app->name = $request->input("name");
            $app->git_repo = $request->input("git_repo");
            if (!$app->save()) {
                return "save failed;";
            }

            return redirect()->route("app-view", ['id' => $id]);
        }
    }

    public function postAddApp(Request $request)
    {
        DB::beginTransaction();
        try {
            $app = new App();
            $app->name = $request->input("name");
            $app->git_repo = "";
            if (!$app->save()) {
                throw new DBException;
            }
            $group = new Group();
            $group->app_id = $app->id;
            $group->name = "local";
            $group->version = 1;
            $group->codeBase = $_SERVER["HOME"] . "/Sites/codeBase";
            $group->deployPath = "/home/x/htdocs/" . $app->name;
            $group->hosts = '';
            if (!$group->save()) {
                throw new DBException;
            }

            $groupOnline = new Group();
            $groupOnline->app_id = $app->id;
            $groupOnline->name = "online";
            $groupOnline->version = 1;
            $groupOnline->codeBase = "/home/x/codeBase/";
            $groupOnline->deployPath = "/home/x/htdocs/" . $app->name;
            $groupOnline
                ->hosts = '';
            if (!$groupOnline->save()) {
                throw new DBException;
            }


            $groupTesting = new Group();
            $groupTesting->app_id = $app->id;
            $groupTesting->name = "testing";
            $groupTesting->codeBase = "/home/x/codeBase/";
            $groupTesting->deployPath = "/home/x/htdocs/" . $app->name;
            $groupTesting->version = 1;
            $groupTesting->hosts = '';
            if (!$groupTesting->save()) {
                throw new DBException;
            }

            DB::commit();
            return redirect()->route("app-view", ['id' => $app->id]);
        } catch (DBException $e) {
            DB::rollback();
            return "post error";
        }

    }

    public function dropApp(Request $request, $id)
    {

    }

    public function appVars(Request $request, $appId, $groupId)
    {

    }

    public function appEnv(Request $request, $appName, $groupName)
    {
        return App::buildEnv($appName, $groupName);
    }

    public function groupEdit(Request $request, $id)
    {

        return view("config.group.edit", ['group' => Group::where("id", $id)->first()]);
    }

    public function groupPostEdit(Request $request, $id)
    {
        $group = Group::where("id", $id)->first();
        if (!$group) {
            return "group not found.";
        }
        $name = $request->input("name");
        $deployPath = $request->input("deployPath");
        $codeBase = $request->input("codeBase");

        $group->name = $name;
        $group->deployPath = $deployPath;
        $group->codeBase = $codeBase;
        $group->hosts = $request->input("hosts");
        if (!$group->save()) {
            $this->redirectWithError($request, trans('zeus.save-failed'));
        }
        return $this->gotoWithSucc($request, trans('zeus.save-succeed'), route('group-edit', ['id' => $id]));
    }

    public function postEnv(Request $request, $groupId)
    {
        /**
         * @var $group Group
         */
        $group = Group::find($groupId);
        if (!$group) {
            return $this->redirectWithError($request, trans('zeus.group-not-exists'));
        }
        try {
            $t1 = microtime(true);
            $content = $request->input("env");
            $group->syncVariablesWithEnvContent($content);
            $t2 = microtime(true);
            return $this->gotoWithSucc($request, trans('zeus.command-succeed', ['time' => number_format(($t2 - $t1), 2)]), route('group-view-env', ['id' => $groupId,'group'=>$group]));
        } catch (\Exception $e) {
            app()->make(ExceptionHandler::class)->report($e);
            return $this->redirectWithError($request, trans('zeus.command-failed', ['msg' => $e->getMessage()]));
        }


    }


    public function groupUpdateCode(Request $request, $groupId)
    {
        /**
         * @var $group Group
         */
        $group = Group::find($groupId);
        if (!$group) {
            return $this->redirectWithError($request, trans('zeus.group-not-exists'));
        }
        try {
            $t1 = microtime(true);
            $group->doOperation('gitPull');
            $t2 = microtime(true);
            return $this->redirectWithSucc($request, trans('zeus.command-succeed', ['time' => number_format(($t2 - $t1), 2)]));
        } catch (\Exception $e) {
            app()->make(ExceptionHandler::class)->report($e);
            return $this->redirectWithError($request, trans('zeus.command-failed', ['msg' => $e->getMessage()]));
        }
    }


    public function groupReadEnv(Request $request, $groupId)
    {
        /**
         * @var $group Group
         */
        $group = Group::find($groupId);
        if (!$group) {
            return $this->redirectWithError($request, trans('zeus.group-not-exists'));
        }
        try {
            $t1 = microtime(true);
            $group->readRemoteEnv();
            $t2 = microtime(true);
            return $this->redirectWithSucc($request, trans('zeus.command-succeed', ['time' => number_format(($t2 - $t1), 2)]));
        } catch (\Exception $e) {
            app()->make(ExceptionHandler::class)->report($e);
            return $this->redirectWithError($request, trans('zeus.command-failed', ['msg' => $e->getMessage()]));
        }
    }

    public function user()
    {
        $remoteUser = RemoteUser::getCurrentUser();
        return [
            'user' => json_decode(json_encode($remoteUser), true),
            'hasPm' => $remoteUser->hasRole('pm'),
            'hasPP' => $remoteUser->hasRole('pp')];
    }

    public function diffEnv(Request $request,$groupId){
        /**
         * @var $group Group
         */
        $group = Group::find($groupId);
        if (!$group) {
            return $this->redirectWithError($request, trans('zeus.group-not-exists'));
        }
        $dbEnvs =   App::getAllEnv($group->app->name, $group->name);



        try {
            $content = $group->readRemoteEnvContent();
            $envStringLoader = new EnvStringLoader($content);
            $envStringLoader->load();
            $config = $envStringLoader->getConfig();
            return view("config.group.diff",['onlineEnv'=>$config,"dbEnv"=>$dbEnvs,
            "keys"=>array_unique(array_merge(array_keys($config),array_keys($dbEnvs))),'group'=>$group]);
        }catch(\Exception $e){
            return $this->redirectWithError($request, 'unknown error');
        }
    }

    public function writeRemote(Request $request,$groupId){
        /**
         * @var $group Group
         */
        $group = Group::find($groupId);
        if (!$group) {
            return $this->redirectWithError($request, trans('zeus.group-not-exists'));
        }
        try {
            $t1 = microtime(true);
            $group->doOperation('writeEnv');
            $t2 = microtime(true);
            return $this->redirectWithSucc($request, trans('zeus.command-succeed', ['time' => number_format(($t2 - $t1), 2)]));
        } catch (\Exception $e) {
            app()->make(ExceptionHandler::class)->report($e);
            return $this->redirectWithError($request, trans('zeus.command-failed', ['msg' => $e->getMessage()]));
        }


    }

}

<?php

namespace App\Http\Controllers;

use app\DBException;
use App\Model\App;
use App\Model\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function apps(Request $request){
        return view("config.app.index",['apps'=>App::paginate(50)]);
    }
    public function addApp(Request $request){
        return view("config.app.create");
    }

    public function appUpdateEnv(Request $request,$appName,$groupName){
        return view("config.app.update",['appName'=>$appName,'groupName'=>$groupName]);
    }

    public function appUpdateEnvPost(Request $request,$appName,$groupName){
        return $request->all();
    }

    public function appEdit(Request $request,$id){
        return view("config.app.edit",['app'=>App::where('id',$id)->first()]);
    }

    public function appRemove(Request $request,$id){
        
    }
    public function appView(Request $request,$id){
        return view("config.app.view",['app'=>App::find($id)]);
    }


    public function appPostEdit(Request $request,$id){
        $app = App::where("id",$id)->first();
        if(!$app){
            return "app not found";
        }else{
            $app->name = $request->input("name");
            $app->git_repo = $request->input("git_repo");
            if(!$app->save()){
                return "save failed;";
            }

            return redirect()->route("app-view",['id'=>$id]);
        }
    }

    public function postAddApp(Request $request){
        DB::beginTransaction();
        try{
            $app = new App();
            $app->name = $request->input("name");
            $app->git_repo = "";
            if(!$app->save()){
                throw new DBException;
            }
            $group = new Group();
            $group->app_id = $app->id;
            $group->name="local";
            $group->version=1;
            $group->codeBase = $_SERVER["HOME"]."/Sites/codeBase";
            $group->deployPath = "/home/x/htdocs/".$app->name;
            if(!$group->save()){
                throw new DBException;
            }

            $groupOnline = new Group();
            $groupOnline->app_id = $app->id;
            $groupOnline->name="online";
            $groupOnline->version=1;
            $groupOnline->codeBase = "/home/x/codeBase/";
            $groupOnline->deployPath = "/home/x/htdocs/".$app->name;
            if(!$groupOnline->save()){
                throw new DBException;
            }


            $groupTesting = new Group();
            $groupTesting->app_id = $app->id;
            $groupTesting->name="testing";
            $groupTesting->codeBase = "/home/x/codeBase/";
            $groupTesting->deployPath = "/home/x/htdocs/".$app->name;
            $groupTesting->version = 1;
            if(!$groupTesting->save()){
                throw new DBException;
            }

            DB::commit();
            return redirect()->route("app-view",['id'=>$app->id]);
        }catch(DBException $e){
            DB::rollback();
            return "post error";
        }

    }
    public function dropApp(Request $request,$id){
        
    }

    public function appVars(Request $request,$appId,$groupId){

    }

    public function appEnv(Request $request,$appName,$groupName){
        return App::buildEnv($appName, $groupName);
    }

    public function groupEdit(Request $request,$id){
        return view("config.group.edit",['group'=>Group::where("id",$id)->first()]);
    }

    public function groupPostEdit(Request $request,$id){
        $group = Group::where("id",$id)->first();
        if(!$group){
            return "group not found.";
        }
        $name = $request->input("name");
        $deployPath = $request->input("deployPath");
        $codeBase = $request->input("codeBase");

        $group->name = $name;
        $group->deployPath = $deployPath;
        $group->codeBase = $codeBase;
        if(!$group->save()){
            return "save error";
        }
        return redirect()->route('group-edit',['id'=>$id]);
    }
}

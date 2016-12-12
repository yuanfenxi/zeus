<?php

namespace App\Http\Controllers;

use app\DBException;
use App\Model\App;
use App\Model\Group;
use App\Model\Value;
use App\Model\Variable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    
    public function postAddApp(Request $request){
        DB::beginTransaction();
        try{
            $app = new App();
            $app->name = $request->input("name");
            if(!$app->save()){
                throw new DBException;
            }
            $group = new Group();
            $group->app_id = $app->id;
            $group->name="local";
            if(!$group->save()){
                throw new DBException;
            }

            $groupOnline = new Group();
            $groupOnline->app_id = $app->id;
            $groupOnline->name="online";
            if(!$groupOnline->save()){
                throw new DBException;
            }


            $groupTesting = new Group();
            $groupTesting->app_id = $app->id;
            $groupTesting->name="testing";
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

}

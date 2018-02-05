<?php

namespace App\Http\Controllers;

use App\AppInstance;
use App\DBException;
use App\Model\App;
use App\Node;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware("onlyUser");
    }

    public function createInstance(Request $request, $appId)
    {
        $app = App::find($appId);
        if (!$app) {
            return $this->redirectWithError($request, "找不到该App");
        }
        $nodes = Node::where("status", "online")->get();

        return view("config.app.createInstance", ["nodes" => $nodes, "app" => $app]);
    }


    public function viewInstance(Request $request, $instanceId)
    {
        $instance = AppInstance::find($instanceId);
        if (!$instance) {
            return $this->redirectWithError($request, "找不到该实例");
        }
        return view("config.app.viewInstance", ["instance" => $instance, "app" => $instance->app, "node" => $instance->node]);
    }

    public function createInstancePost(Request $request, $appId)
    {
        $app = App::find($appId);
        if (!$app) {
            return $this->redirectWithError($request, "找不到该App");
        }
        $nodeId = $request->input("node");
        if (!$nodeId) {
            return $this->redirectWithError($request, "请选择节点");
        }

        /**
         * @var $node Node
         */
        $node = Node::find($nodeId);
        if (!$node) {
            return $this->redirectWithError($request, "节点不存在");
        }
        DB::beginTransAction();
        try {

            /**
             * 先查找该节点上当前运行的最大port
             */

            $appInstance = new AppInstance();
            $appInstance->app_id = $appId;
            $appInstance->node_id = $nodeId;
            $appInstance->instance_name = "-" . rand(11111, 99999);
            $appInstance->port = $node->decidePort();
            if ($app->language == "nginx") {
                $appInstance->port = "80";
            }
            if ($app->language == "ws") {
                $appInstance->port = 4998;
            }
            if ($app->language == "proxy") {
                $appInstance->port = 7788;
            }
            if ($app->language == "portman") {
                $appInstance->port = 7777;
            }

            if (!$appInstance->save()) {
                throw new DBException("保存失败");
            }

            $appInstance->instance_name = $app->name . "-" . $appInstance->id;
            if (!$appInstance->save()) {
                throw new DBException("无法保存");
            }


            DB::commit();
            return $this->gotoWithSucc($request, "保存成功", route("view-instance", ["id" => $appInstance->id]));
        } catch (\Exception $e) {
            DB::rollback();
            app()->make(ExceptionHandler::class)->report($e);
            return $this->redirectWithError($request, "保存失败或其他错误:" . $e->getMessage());
        }

    }

    public function all(Request $request)
    {
        $ins = AppInstance::get();
        return view("config.app.all", ["all" => $ins]);
    }

    public function startInstance(Request $request)
    {
        $instanceId = $request->input("inst_id");
        $instance = AppInstance::find($instanceId);
        $appOfPortman = App::where("name", "portman")->first();
        if (!$appOfPortman) {
            return $this->redirectWithError($request, "名为portman的实例不存在");
        }
        if ($instance) {
            $node = $instance->node;
            $portman = AppInstance::where("node_id", $node->id)
                ->where("app_id", $appOfPortman->id)->first();
            if (!$portman) {
                return $this->redirectWithError($request, "该节点上没有portman实例");

            }
            //$httpClient = new Client
        }
    }
}

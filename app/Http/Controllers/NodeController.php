<?php

namespace App\Http\Controllers;

use App\Node;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    public function __construct()
    {
        $this->middleware("onlyUser");
    }

    public function index(Request $request)
    {
        $nodes = Node::paginate(20);
        return view("node.index", ["nodes" => $nodes]);
    }

    public function create(Request $request)
    {
        return view("node.create");
    }

    protected function copyNodeFromRequest(Request $request, &$node)
    {
        $node->status = $request->input("status");
        $node->colo = $request->input("colo");
        $node->ip = $request->input("ip");
        $node->minPort = $request->input("minPort");
        $node->maxPort = $request->input("maxPort");

    }

    public function post(Request $request)
    {
        $id = $request->input("id");
        if ($id) {
            $node = Node::find($id);
            if (empty($node)) {
                return "该节点找不到";
            }
        } else {
            $node = new Node();
        }
        $this->copyNodeFromRequest($request, $node);
        if ($node->save()) {
            return $this->gotoWithSucc($request, "保存成功", url("/node/view/" . $node->id));
        } else {
            return $this->redirectWithError($request, "保存失败");
        }


    }

    public function remove()
    {

    }

    public function edit()
    {

    }

    public function view(Request $request, $id)
    {
        $node = Node::find($id);
        return view("node.view", ["node" => $node]);
    }
}

@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            @lang('zeus.node-list')
            <a href="{{route('node-create')}}" class="btn btn-success  btn-lg pull-right">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                @lang('zeus.create-new-node')
            </a>
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered">
            <tr>
                <th>IP</th>
                <th>端口范围</th>
                <th>状态</th>
            </tr>
            <?php foreach ($nodes as $node) { ?>
                <tr>
                    <td>{{ $node->ip}}</td>
                    <td>{{$node->minPort}} ~ {{$node->maxPort}}</td>
                    <td>{{$node->status}}</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
@endsection
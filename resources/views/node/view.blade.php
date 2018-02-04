@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            节点详情:{{$node->ip}}
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-borderd table-strip">
            <tr>
                <th>IP</th>
                <td>{{$node->ip}}</td>
            </tr>
            <tr>
                <th>minPort:</th>
                <td>{{$node->minPort}}</td>
            </tr>
            <tr>
                <th>maxPort:</th>
                <td>{{$node->maxPort}}</td>
            </tr>
            <tr>
                <th>colo:</th>
                <td>{{$node->colo}}</td>
            </tr>
            <tr>
                <th>status:</th>
                <td>{{$node->status}}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
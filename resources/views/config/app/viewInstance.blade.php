@extends('layouts.app')
@section('content')

<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            查看实例详情:
        </h3>
    </div>
    <div class="panel-body">

        <table class="table table-bordered table-striped">

            <tr>
                <th>App:</th>
                <td>
                    <a href="{{route('app-view',['id'=>$app->id])}}">
                        {{$app->name}}
                    </a>
                </td>
            </tr>

            <tr>
                <th>Node:</th>
                <td>
                    <a href="{{route('node-view',['id'=>$node->id])}}">
                        {{$node->ip}}
                    </a>
                </td>
            </tr>

            <tr>
                <th>Port:</th>
                <td>{{$instance->port}}</td>
            </tr>

            <tr>
                <th>
                    InstanceName:
                </th>
                <td>
                    {{$instance->instance_name }}
                </td>
            </tr>

            <tr>
                <th>Status:</th>
                <td>
                    //
                </td>
            </tr>

        </table>

    </div>
</div>

@endsection
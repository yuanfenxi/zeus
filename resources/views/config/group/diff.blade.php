@extends('layouts.app')
@section('content')


<div class="panel panel-default  ">
    <div class="panel-heading">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item ><a href="{{route('apps')}}">@lang('zeus.app-list')</a></el-breadcrumb-item>
            <el-breadcrumb-item>  <a href="{{route('app-view',['id'=>$group->app_id])}}">
                    {{$group->app->name}}
                </a></el-breadcrumb-item>
            <el-breadcrumb-item>@lang('zeus.group-diff-env',['name'=>$group->name])</el-breadcrumb-item>

        </el-breadcrumb>

    </div>
    <div class="panel-body">
    <table class="table table-hover table-bordered table-striped">
        <tr>
            <th>-</th>
            <th>@lang("zeus.remote-server")</th>
            <th>@lang("zeus.database-env")</th>
        </tr>
        <?php foreach ($keys as $key){
            $online = '';
             if(isset($onlineEnv[$key])){
                $online= $onlineEnv[$key];
            }else{
                $online= "-";
            }

            $db = '';
            if(isset($dbEnv[$key])){
                $db= $dbEnv[$key];
            }else{
                $db= '-';
            }
            $class='hidden-row';
            if($db!=$online){
                $class='red';
            }
            ?>
            <tr class="{{$class}}">
                <th>{{$key}}</th>
                <td>
                    {{$online}}
                </td>
                <td>
                   {{$db}}
                </td>
            </tr>
        <?php } ?>
    </table>
        <div class="row">
            <a href="{{route('group-read-env',['id'=>$group->id])}}" class="btn btn-warning">@lang('zeus.group-read-env',['name'=>$group->name])</a>

            <a href="{{route('group-edit-env',['id'=>$group->id])}}" class="">
                @lang('zeus.group-edit-env',['name'=>$group->name])
            </a>

            <a href="{{route('group-write-remote-env',['id'=>$group->id])}}" class='btn btn-danger'>
                @lang('zeus.group-write-remote-env',['name'=>$group->name])
            </a>





        </div>
    </div>
   </div>

@endsection
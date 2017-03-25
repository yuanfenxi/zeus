@extends('layouts.app')
@section('content')


<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            @lang('zeus.group-diff-env')
        </h3>
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

            <a href="{{route('group-view-env',['id'=>$group->id])}}">
                @lang('zeus.group-view-env',['name'=>$group->name])
            </a>

            <a href="{{route('group-write-remote-env',['id'=>$group->id])}}">
                @lang('zeus.group-write-remote-env',['name'=>$group->name])
            </a>

        </div>
    </div>
   </div>
<?php
var_dump($keys);?>
@endsection
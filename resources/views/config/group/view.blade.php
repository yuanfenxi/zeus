<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2016/12/12
 * Time: 下午6:31
 */
?>
@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">

    <div class="panel-heading">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item ><a href="{{route('apps')}}">@lang('zeus.app-list')</a></el-breadcrumb-item>
            <el-breadcrumb-item>  <a href="{{route('app-view',['id'=>$group->app_id])}}">
                    {{$group->app->name}}
                </a></el-breadcrumb-item>
            <el-breadcrumb-item>@lang('zeus.group-view-env',['name'=>$group->name])</el-breadcrumb-item>

        </el-breadcrumb>

     
    </div>

    <div class="panel-body">
        <div class="row">
            <label for="env" class="col-md-4 control-label right-label">
                <div class="pull-right">环境配置:</div>
            </label>
            <div class="col-md-6">
            <textarea rows="8" cols="60" id="env" class="form-control" name="env" readonly="readonly"><?php
                echo htmlspecialchars(\App\Model\App::buildEnv($appName, $groupName));
                ?></textarea>
            </div>
        </div>
    </div>
</div>


@endsection
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

        <form class="form-horizontal" role="form" method="POST" action="{{ route('group-post-env',['id'=>$group->id]) }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('env') ? ' has-error' : '' }}">
                <label for="env" class="col-md-4 control-label right-label">
                    <div>@lang('zeus.env')</div>
                </label>
                <div class="col-md-6">
                    <el-input
                        type="textarea"
                        :autosize="{ minRows: 2, maxRows: 40}"
                        placeholder="请输入内容"
                        id="env"
                        value=""
                        name='env'
                    >
                    </el-input>

                    @if ($errors->has('env'))
                     <span class="help-block">
                          <strong>{{ $errors->first('env') }}</strong>
                     </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-md-offset-4" >
                    <el-button type="primary" native-type="submit">提交</el-button>
                </div>
            </div>

        </form>

    </div>
</div>


@endsection
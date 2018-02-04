@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item ><a href="{{route('apps')}}">@lang('zeus.app-list')</a></el-breadcrumb-item>
            <el-breadcrumb-item>  <a href="{{route('app-view',['id'=>$group->app_id])}}">
                    {{$group->app->name}}
                </a></el-breadcrumb-item>
            <el-breadcrumb-item>@lang('zeus.edit-group',['name'=>$group->name])</el-breadcrumb-item>

        </el-breadcrumb>


    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('group-post-edit',['id'=>$group->id]) }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label right-label"><div>
                        @lang('zeus.group-name')
                    </div></label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ $group->name }}">
                    @if ($errors->has('name'))
                 <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                 </span>
                    @endif
                </div>
            </div>



            <div class="form-group{{ $errors->has('codeBase') ? ' has-error' : '' }}">
                <label for="codeBase" class="col-md-4 control-label right-label"><div>
                        @lang('zeus.group-codeBase')
                    </div></label>
                <div class="col-md-6">
                    <input id="codeBase" type="text" class="form-control" name="codeBase" value="{{ $group->codeBase }}" placeholder="/var/www/codebase/">
                    @if ($errors->has('codeBase'))
              <span class="help-block">
                   <strong>{{ $errors->first('codeBase') }}</strong>
              </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('deployPath') ? ' has-error' : '' }}">
                <label for="deployPath" class="col-md-4 control-label right-label"><div>
                        @lang('zeus.group-deployPath'):</div></label>
                <div class="col-md-6">
                    <input id="deployPath" type="text" class="form-control" name="deployPath" value="{{ $group->deployPath }}" placeholder="/var/www/example.com/">
                    @if ($errors->has('deployPath'))
                 <span class="help-block">
                      <strong>{{ $errors->first('deployPath') }}</strong>
                 </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('hosts') ? ' has-error' : '' }}">
                <label for="hosts" class="col-md-4 control-label right-label">
                    <div>@lang('zeus.group-hosts'):</div>
                </label>
                <div class="col-md-6">
                    <textarea id="hosts" class="form-control" name="hosts"
                    rows="6" cols="50" placeholder="q1.example.com
q2.example.com//备份机
//一行一个,用双斜线表示注释;">{{$group->hosts}}</textarea>
                    @if ($errors->has('hosts'))
                         <span class="help-block">
                              <strong>{{ $errors->first('hosts') }}</strong>
                         </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('domainName') ? ' has-error' : '' }}">
                <label for="domainName" class="col-md-4 control-label right-label">
                    <div>domainName:</div>
                </label>
                <div class="col-md-6">
                    <input id="domainName" type="text" class="form-control" name="domainName"
                           value="{{old('domainName')}}">
                    @if ($errors->has('domainName'))
                    <span class="help-block">
                              <strong>{{ $errors->first('domainName') }}</strong>
                         </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>
    </div>
   </div>

@endsection
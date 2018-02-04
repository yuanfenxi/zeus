@extends('layouts.app')
@section('content')

<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item ><a href="{{route('apps')}}">@lang('zeus.app-list')</a></el-breadcrumb-item>
                <el-breadcrumb-item> @lang('zeus.edit-app',['name'=>$app->name])</el-breadcrumb-item>

            </el-breadcrumb>

        </h3>


    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('app-post-edit',['id'=>$app->id]) }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label right-label">
                    <div>名字:</div>
                </label>
                <div class="col-md-6">
                    <el-input  placeholder="请输入内容" name="name" id="name" value="{{$app->name}}" ></el-input>

                    @if ($errors->has('name'))
                 <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                 </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('git_repo') ? ' has-error' : '' }}">
                <label for="git_repo" class="col-md-4 control-label right-label">
                    <div>git仓库地址:</div>
                </label>
                <div class="col-md-6">
                    <input id="git_repo" type="text" class="form-control" name="git_repo" value="{{$app->git_repo}}">
                    @if ($errors->has('git_repo'))
                 <span class="help-block">
                      <strong>{{ $errors->first('git_repo') }}</strong>
                 </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
                <label for="language" class="col-md-4 control-label right-label">
                    <div>Language:</div>
                </label>
                <div class="col-md-6">
                    <input id="language" type="text" class="form-control" name="language" value="{{old('language')}}">
                    @if ($errors->has('language'))
                    <span class="help-block">
                              <strong>{{ $errors->first('language') }}</strong>
                         </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <el-button type="primary" native-type="submit">提交</el-button>
                </div>
            </div>
        </form>

    </div>
</div>


@endsection
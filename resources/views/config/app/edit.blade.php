@extends('layouts.app')
@section('content')

<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            <ol class="breadcrumb">
                <li><a href="{{route('apps')}}">@lang('zeus.app-list')</a></li>
                <li class="active">  @lang('zeus.edit-app',['name'=>$app->name])</li>
            </ol>
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
                    <input id="name" type="text" class="form-control" name="name" value="{{$app->name}}">
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


            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>

    </div>
</div>


@endsection
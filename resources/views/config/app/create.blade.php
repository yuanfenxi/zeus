@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            <ol class="breadcrumb">
                <li><a href="{{route('apps')}}">@lang('zeus.app-list')</a></li>
                <li class="active"> @lang('zeus.create-new-app')</li>
            </ol>
        </h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('app-post-add') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label right-label">
                    <div>名称:</div>
                </label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{old('name')}}">
                    @if ($errors->has('name'))
                 <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
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
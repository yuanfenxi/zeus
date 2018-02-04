@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            添加节点
        </h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('node-post') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('ip') ? ' has-error' : '' }}">
                <label for="ip" class="col-md-4 control-label right-label">
                    <div>IP</div>
                </label>
                <div class="col-md-6">
                    <input id="ip" type="text" class="form-control" name="ip" value="{{old('ip')}}">
                    @if ($errors->has('ip'))
                    <span class="help-block">
                  <strong>{{ $errors->first('ip') }}</strong>
             </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('minPort') ? ' has-error' : '' }}">
                <label for="minPort" class="col-md-4 control-label right-label">
                    <div>minPort</div>
                </label>
                <div class="col-md-6">
                    <input id="minPort" type="text" class="form-control" name="minPort" value="{{old('minPort')}}">
                    @if ($errors->has('minPort'))
                    <span class="help-block">
                          <strong>{{ $errors->first('minPort') }}</strong>
                     </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('maxPort') ? ' has-error' : '' }}">
                <label for="maxPort" class="col-md-4 control-label right-label">
                    <div>maxPort:</div>
                </label>
                <div class="col-md-6">
                    <input id="maxPort" type="text" class="form-control" name="maxPort" value="{{old('maxPort')}}">
                    @if ($errors->has('maxPort'))
                    <span class="help-block">
                          <strong>{{ $errors->first('maxPort') }}</strong>
                     </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('colo') ? ' has-error' : '' }}">
                <label for="colo" class="col-md-4 control-label right-label">
                    <div>colo:</div>
                </label>
                <div class="col-md-6">
                    <input id="colo" type="text" class="form-control" name="colo" value="bj">
                    @if ($errors->has('colo'))
                    <span class="help-block">
                          <strong>{{ $errors->first('colo') }}</strong>
                     </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                <label for="status" class="col-md-4 control-label right-label">
                    <div>status:</div>
                </label>
                <div class="col-md-6">
                    <input id="status" type="text" class="form-control" name="status" value="{{old('status')}}">
                    @if ($errors->has('status'))
                    <span class="help-block">
                          <strong>{{ $errors->first('status') }}</strong>
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
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

<form class="form-horizontal" role="form" method="POST" action="{{ route('app-post-update',['appName'=>$appName,'groupName'=>$groupName]) }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('env') ? ' has-error' : '' }}">
        <label for="env" class="col-md-4 control-label right-label">
            <div>环境配置:</div>
        </label>
        <div class="col-md-6">
            <textarea rows="8" cols="60" id="env" class="form-control" name="env"><?php
                echo htmlspecialchars(\App\Model\App::buildEnv($appName, $groupName));
                ?></textarea>

        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </div>
</form>
@endsection
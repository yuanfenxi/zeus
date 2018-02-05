@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            添加节点:
        </h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST"
              action="{{ route('create-instance-post',['appId'=>$app->id]) }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('nodes') ? ' has-error' : '' }}">
                <label for="nodes" class="col-md-4 control-label right-label">
                    <div>选择节点:</div>
                </label>
                <div class="col-md-6">

                    <select id="node" name="node">
                        <?php foreach ($nodes as $node) { ?>
                            <option value="{{$node->id}}">{{$node->ip}}</option>
                        <?php } ?>
                    </select>
                    @if ($errors->has('nodes'))
                    <span class="help-block">
                      <strong>{{ $errors->first('nodes') }}</strong>
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
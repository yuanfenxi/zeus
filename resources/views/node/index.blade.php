@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            @lang('zeus.node-list')
            <a href="{{route('node-create')}}" class="btn btn-success  btn-lg pull-right">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                @lang('zeus.create-new-node')
            </a>
        </h3>
    </div>
    <div class="panel-body">

    </div>
</div>
@endsection
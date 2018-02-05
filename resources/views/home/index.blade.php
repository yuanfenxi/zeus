@extends('layouts.app')
@section('content')

<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            @lang('zeus.dashboard')
        </h3>
    </div>
    <div class="panel-body">


        <a href="{{route('apps')}}" class="btn btn-success">
            @lang("zeus.app-index")
        </a>

        <br/>
        <br/>
        <br/>
        <a href="{{route('node-index')}}" class="btn btn-success">
            @lang("zeus.node-index")
        </a>

    </div>
</div>

@endsection

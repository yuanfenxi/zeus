@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            添加Host
        </h3>
    </div>
    <div class="panel-body">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('add-host') }}">
        {{ csrf_field() }}
    </form>
    </div>
   </div>
@endsection
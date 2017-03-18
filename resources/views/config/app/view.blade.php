@extends('layouts.app')
@section('content')


<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            <ol class="breadcrumb">
                <li><a href="{{route('apps')}}">@lang('zeus.app-list')</a></li>
                <li class="active"> @lang('zeus.view-app',['name'=>$app->name])</li>
            </ol>


        </h3>

    </div>
    <div class="panel-body">
        <table class="table table-responsive table-striped table-bordered">
            <tr>
                <th>@lang('zeus.app-name'):</th>
                <td>{{$app->name}}
                    <a href="{{route('app-edit',['id'=>$app->id])}}" class="">@lang('zeus.edit')</a>
                </td>
            </tr>
            <tr>
                <th>@lang('zeus.git-repo-address'):</th>
                <td>{{$app->git_repo}}
                    <a href="{{route('app-edit',['id'=>$app->id])}}" class="">@lang('zeus.edit')</a>
                </td>
            </tr>


        </table>


        <h3>应用分组环境:</h3>
        <table class="table table-striped table-responisve table-bordered">
            <?php foreach ($app->groups as $group) { ?>
                <tr>
                    <td>
                        <a href="{{route('group-edit',['id'=>$group->id])}}">{{$group->name}}</a>
                    </td>
                    <td>
                        <a href="{{route('app-update',['appName'=>$app->name,'groupName'=>$group->name])}}">view
                            {{$group->name}} env</a>
                    </td>
                </tr>

            <?php } ?>
        </table>

    </div>
</div>


@endsection
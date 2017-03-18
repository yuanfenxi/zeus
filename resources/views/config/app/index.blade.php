@extends('layouts.app')
@section('content')
<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2016/12/11
 * Time: 上午12:22
 */
?>
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            @lang('zeus.app-list')
            <a href="{{route('app-add')}}" class="btn btn-success  btn-lg pull-right">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                @lang('zeus.create-new-app')
            </a>
        </h3>
    </div>
    <div class="panel-body">

        <table class="table table-responsive table-striped table-bordered">
            <tr>
                <th width="80%">@lang('zeus.app-name')</th>
           
                <th>@lang('zeus.edit')</th>
                <th>@lang('zeus.remove')</th>
            </tr>
            <?php foreach($apps as $app){?>
                <tr>
                    <td>
                        <a href="{{route('app-view',['id'=>$app->id])}}">
                        {{$app->name}}
                            </a>
                    </td>


                    <td>

                        <a href="<?php echo  route('app-edit',['id'=>$app->id]);?>" class="btn btn-warning">  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> @lang('zeus.edit')</a>
                    </td>
                    <td>
                        <a href="<?php echo  route('app-remove',['id'=>$app->id]);?>" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            @lang('zeus.remove')</a>
                    </td>
                </tr>
            <?php }?>
        </table>
        <div class="paginate">
            {{$apps->render()}}
        </div>

    </div>
   </div>



@endsection

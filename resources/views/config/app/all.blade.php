@extends('layouts.app')
@section('content')
<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            All instances
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered">
            <?php foreach ($all as $item) { ?>
                <tr>
                    <th>
                        {{$item->app->language}}
                    </th>
                    <th>
                        {{$item->node->ip}}
                    </th>
                    <th>
                        {{$item->instance_name}}
                    </th>
                    <th>
                        {{$item->port}}
                    </th>
                    <th>
                        {{$item->status}}
                    </th>
                    <th>
                        {{ $item->last_check_at>0?date("Y-m-d H:i:s",$item->last_check_at):"-" }}
                    </th>
                </tr>
            <?php } ?>
        </table>

    </div>
</div>
@endsection
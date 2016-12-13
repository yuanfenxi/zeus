@extends('layouts.app')
@section('content')


<table class="table-striped table-bordered ">
    <tr>
        <th>Name:</th>
        <td>{{$app->name}}</td>
    </tr>
    <tr>
        <th>git_repo:</th>
        <td>{{$app->git_repo}}</td>
    </tr>

    <tr>
        <th>Groups:</th>
        <td>
            <?php foreach($app->groups as $group){?>
                <a href="{{route('group-edit',['id'=>$group->id])}}">{{$group->name}}</a>,
                <br/>
            <?php } ?>
        </td>
    </tr>

</table>



@endsection
<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2016/12/11
 * Time: 上午12:22
 */
?>
<a href="{{route('app-add')}}">Add</a>
<table class="table table-responsive table-striped table-bordered">
<?php foreach($apps as $app){?>
    <tr>
        <td>
            {{$app->name}}
        </td>
        <td>
            <?php foreach($app->groups as $group){?>
            <a href="{{route('app-update',['appName'=>$app->name,'groupName'=>$group->name])}}">view {{$group->name}} env</a>

            <?php } ?>
        </td>
        <td>
            <a href="{{route('app-view',['id'=>$app->id])">view</a>
        </td>
    </tr>
<?php }?>
</table>
<div class="paginate">
    {{$apps->render()}}
</div>

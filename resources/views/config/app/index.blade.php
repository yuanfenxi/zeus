<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2016/12/11
 * Time: 上午12:22
 */
?>
<table class="table table-responsive table-striped table-bordered">
<?php foreach($apps as $app){?>
    <tr>
        <td>
            {{$app->name}}
        </td>
        <td>
            <a href="{{route('app-view',['id'=>$app->id])}}">view</a>
        </td>
    </tr>
<?php }?>
</table>
<div class="paginate">
    {{$apps->render()}}
</div>

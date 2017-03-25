@extends('layouts.app')
@section('content')

<div class="panel panel-default  ">
    <div class="panel-heading">
        <h3>
            日志列表
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-hover table-bordered table-striped table-responsive">
            <tr>
                <th>时间</th><th>执行人</th><th>命令</th>
                <th>结果</th>
            </tr>
            <?php foreach ($logs as $log){?>
                <tr>
                    <td>{{$log->created_at}}</td>
                    <td>{{$log->email}}</td>
                    <td>{{$log->command}}</td>
                    <td>{{$log->result}}</td>
                </tr>
                <tr>
                    <td colspan="4">
                        输出:<br/>
                        <el-input
                            type="textarea"

                            :rows="2"
                            placeholder="请输入内容"
                            :autosize="{ minRows: 2, maxRows: 6}"
                            value="{{$log->output}}"
                          >
                        </el-input>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <div class="paginate">
            {{$logs->render()}}
        </div>
    </div>
   </div>

@endsection
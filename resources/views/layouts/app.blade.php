<?php
$t = 2017031904; ?>
<html>
<head>
    <title>
        @lang('customize.site')
    </title>
    <link rel="stylesheet" href="/css/app.css?t={{$t}}">
    <link rel="stylesheet" href="/css/ele/index.css?t={{$t}}">
    <style type="text/css">
        .red {
            color:red;
        }
        .hidden-row {
            display:none;
        }
    </style>
</head>

<body>

<div class="row">
    <div class="col-md-6">
        &nbsp;
    </div>
    <div class="col-md-6">
        <div class="pull-right" style="padding-right:1em;">
            <a href="/logs/index">@lang("zeus.logs-index")</a>
            <?php echo \NvwaCommon\Uic\RemoteUser::getCurrentUser()->name . "(" .
                \NvwaCommon\Uic\RemoteUser::getCurrentUser()->email . ")"; ?>
        </div>

    </div>
</div>
<div id="app">

    <?php

    $notice = app()->request->session()->get('notice');
    if ($notice) {
        echo '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>'.trans('zeus.notice').'</strong> ' . $notice . '
</div>';
    }
    $error = app()->request->session()->get('error');
    if ($error) {
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>'.trans('zeus.warning').'</strong> ' . $error . '
</div>';
    }
    $success = app()->request->session()->get("success");
    if ($success) {
        echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>'.trans('zeus.congratulations').'</strong> ' . $success . '
</div>';
    }
    ?>

    @yield("content")

   
    <foot></foot>
</div>
<script type="text/javascript" src="/js/app.js?t={{$t}}"></script>
</body>
</html>



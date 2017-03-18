<?php
$t  =2017031902;?><html>
<head>
    <title>
        @lang('customize.site')
    </title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
<div id="app"></div>
<?php

$notice = app()->request->session()->get('notice');
if($notice){
echo '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>注意:</strong> '.$notice.'
</div>';
}

$error = app()->request->session()->get('error');
if($error){
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>警告:</strong> '.$error.'
</div>';
}
$success = app()->request->session()->get("success");
if($success){
    echo '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>恭喜:</strong> '.$success.'
</div>';
}
?>

@yield("content")

<script type="text/javascript" src="/js/app.js?t={{$t}}"></script>
</body>
</html>



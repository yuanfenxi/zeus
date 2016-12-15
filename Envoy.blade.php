@servers(['q1'=>'x@q2.glz8.net','q2'=>'x@q2.glz8.net'])

@task('f',['on'=>'q1'])
    ls -la
@endtask
@task('update:bigeye',['on'=>'q2'])
    php /home/x/htdocs/zeus.glz8.net/artisan zeus:gitPull  bigeye online 
@endtask

@task('deploy:bigeye',['on'=>'q2'])
php /home/x/htdocs/zeus.glz8.net/artisan zeus:deploy  bigeye online
@endtask

@after
@slack("https://hook.bearychat.com/=bw8Zf/incoming/9ecd1f4b470eeeb3d9a9ee1da0ebf0be","@xurenlu@#glz8.com",'我觉得还可以')
@endafter

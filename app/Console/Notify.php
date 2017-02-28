<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2017/2/28
 * Time: 下午5:43
 */

namespace App\Console;


trait Notify
{
    public function sendMsgToStaff($email,$msg){
        return file_get_contents("https://e.glz8.net/api/wechat/sendMsgToStaff?email={$email}.com&msg=".urlencode($msg));
    }
}
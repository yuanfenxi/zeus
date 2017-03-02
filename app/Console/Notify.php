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
    public function sendMsgToStaff($emails,$msg){
        $mailSections = [];
        foreach($emails as $email){
            $mailSections[]='email[]='.$email;
        }

        return file_get_contents("https://e.glz8.net/api/wechat/sendMsgToStaff?msg=".urlencode($msg)."&".
        join("&",$mailSections));
    }
    private function buildUrl($emails,$msg){
        $mailSections = [];
        foreach($emails as $email){
            $mailSections[]='email[]='.$email;
        }
        return "https://e.glz8.net/api/wechat/sendMsgToStaff?msg=".urlencode($msg)."&".
            join("&",$mailSections);
    }
}
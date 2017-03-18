<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2017/3/19
 * Time: 上午1:47
 */

namespace App\Zeus;


class HostHelper
{
    const COMMAND = 'ssh ';
    public static function parseHost($text){
        $lines = explode("\n",$text);
        $hosts = [];
        foreach($lines as $line){
            $line = trim($line);
            if(empty($line)){
                continue;
            }
            if(strpos($line, "//")===false){
                $hosts[] = trim($line);
                continue;
            }
            $result = substr($line, 0,strpos($line, "//"));
            if(!empty(trim($result))){
                $hosts[] = trim($result);
            }
        }
        return $hosts;
    }

}
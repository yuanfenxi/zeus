<?php

namespace App\Model;

use app\DBException;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    //

    public  function putValue($groupId,$newValue){
        $value = Value::where("app_id",$this->app_id)->where("group_id",$groupId)->where("variable_id",$this->id)->first();
        if($value){
            $value->value = $newValue;
            if(!$value->save()){
                throw new DBException;
            }
        }else{
            $value = new Value();
            $value->app_id = $this->app_id;
            $value->group_id = $groupId;
            $value->variable_id = $this->id;
            $value->value = $newValue;
            if(!$value->save()){
                throw new DBException;
            }
        }
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //

    public function app(){
        return $this->belongsTo('App\Model\App','app_id');
    }
}

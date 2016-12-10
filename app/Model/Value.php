<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    //
    public function variable(){
        return $this->belongsTo('App\Model\Variable');
    }
}

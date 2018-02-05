<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppInstance extends Model
{
    public function app()
    {
        return $this->belongsTo('App\Model\App');
    }

    public function node()
    {
        return $this->belongsTo('App\Node');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Permission extends Model
{
    //
    public function module(){
        return $this->hasOne('App\Module','id','module_id');
    }
}

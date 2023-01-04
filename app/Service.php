<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function category(){
       return $this->belongsTo('App\Category');
    }
}

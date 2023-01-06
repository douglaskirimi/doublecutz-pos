<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesCommission extends Model
{
    public function employee(){
        return $this->belongsTo('App\User');
    }

    public function invoice(){
        return $this->belongsTo('App\Invoice');
    }
}

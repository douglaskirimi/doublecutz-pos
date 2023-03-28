<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesCommission extends Model
{

     // protected $dateFormat = 'U';


    public function invoice(){
        return $this->belongsTo('App\Invoice','workagent_id');
    }

    public function employee(){
        return $this->belongsTo('App\User','workagent_id');
    }
}

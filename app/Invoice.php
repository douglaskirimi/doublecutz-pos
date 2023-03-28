<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    public function sale(){
        return $this->hasMany('App\Sale');
    } 
    public function salecommissions(){
        return $this->hasMany('App\SaleCommission','workagent_id');
    }

    public function customer(){
        return $this->belongsTo('App\Customer');
    }
    public function user(){
        return $this->belongsTo('App\User','workagent_id');
    }

    public function payment(){
        return $this->hasMany("App\Payment");
    }
    // public function paid(){
    //     // return $this->hasOne(Payment::class,"invoice_id")
    //     // ->join('invoices as i', 'invoice_id', '=', 'i.id')
    //     // ->groupBy("invoice_id")->
    //     // selectRaw("100");//->groupBy("invoice_id")->get();
    //     return $this->hasOne("100");
    // }

}

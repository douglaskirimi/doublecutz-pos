<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    public function sale(){
        return $this->hasMany('App\Sale');
    }

    public function customer(){
        return $this->belongsTo('App\Customer');
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

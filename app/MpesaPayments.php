<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MpesaPayments extends Model
{
       protected $fillable = [
        'MerchantRequestID',
        'CheckoutRequestID',
        'ResultCode',
        'ResultDesc',
        'Amount',
        'MpesaReceiptNumber',
        'Status',
        'TransactionDate',
        'PhoneNumber'];

}

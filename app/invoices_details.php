<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    protected $table = "invoices_details";
    protected $fillable = [
    'invoice_number',
    'invoice_id',
    'product',
    'section',
    'status',
    'value_status',
    'Payment_date',
    'note',
    'user'
];
    public $timestamps = true;
}

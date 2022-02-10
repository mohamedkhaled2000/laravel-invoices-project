<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes;
    protected $fillable = [
    'invoice_number',
    'invoice_data',
    'due_data',
    'product',
    'section_id',
    'Amount_Collection',
    'Amount_Commission',
    'Discount',
    'Value_VAT',
    'Rate_VAT',
    'Total',
    'status',
    'value_status',
    'note'];
    public $timestamps = true;

    public function sections()
    {
        return $this->belongsTo(sections::class, 'section_id', 'id');
    }
}

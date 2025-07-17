<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandwidthSaleInvoiceDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'bandwidth_sale_invoice_id',
        'item_id',
        'description',
        'unit',
        'qty',
        'business_id',
        'rate',
        'vat',
        'from_date',
        'to_date',
        'total',
    ];

    public function getItem()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function getInvoice()
    {
        return $this->belongsTo(BandwidthSaleInvoice::class, 'bandwidth_sale_invoice_id','id');
    }
}

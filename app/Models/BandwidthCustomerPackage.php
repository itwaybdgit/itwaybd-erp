<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandwidthCustomerPackage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

   function item() {
      return $this->belongsTo(Item::class,'item_id','id');
   }
   function details() {
      return $this->hasMany(BandwidthSaleInvoiceDetails::class,'bandwidth_sale_invoice_id','id');
   }

   function customer() {
      return $this->belongsTo(BandwidthCustomer::class,'bandwidht_customer_id','id');
   }
}

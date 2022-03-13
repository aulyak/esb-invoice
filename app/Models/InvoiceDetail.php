<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
  use HasFactory;
  protected $table = 'invoice_details';

  public function invoice()
  {
    return $this->belongsTo(Invoice::class);
  }

  public function subItem()
  {
    return $this->belongsTo(SubItem::class);
  }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
  use HasFactory;
  protected $table = 'sub_items';

  public function invoiceDetail()
  {
    return $this->hasMany(InvoiceDetail::class);
  }

  public function item()
  {
    return $this->belongsTo(Item::class);
  }
}
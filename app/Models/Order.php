<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getActionAttribute()
    {
        return '<div class="action-wrap">
            <a href="/order/edit-'.$this->order_number.'"  class="table-action btn  btn-primary btn-sm waves-effect waves-light">
                <i class="mdi mdi-file-document-edit-outline"></i>Edit
            </a>
            <div onclick="deleteProduct(`'.$this->order_number.'`)" class="table-action btn btn-secondary btn-sm waves-effect waves-light">
                <i class="mdi mdi-delete"></i>Delete
            </div>

        </div>
       ';
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id');
    }
}

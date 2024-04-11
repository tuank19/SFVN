<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['uuid','name', 'description', 'price', 'category_id', 'unit', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function order_detail()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_id');
    }


    public function getActionAttribute()
    {
        return '<div class="action-wrap">
            <a href="/product/edit-'.$this->uuid.'"  class="table-action btn  btn-primary btn-sm waves-effect waves-light">
                <i class="mdi mdi-file-document-edit-outline"></i>Edit
            </a>
            <div onclick="deleteProduct(`'.$this->uuid.'`)" class="table-action btn btn-secondary btn-sm waves-effect waves-light">
                <i class="mdi mdi-delete"></i>Delete
            </div>

        </div>
       ';
    }
}

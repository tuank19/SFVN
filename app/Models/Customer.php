<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes; // Sử dụng SoftDeletes trait

    protected $dates = ['deleted_at']; // Định nghĩa cột deleted_at là một cột ngày tháng
}
